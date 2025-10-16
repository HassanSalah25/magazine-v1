<?php

namespace App\Http\Controllers;

use App\Services\SaaSTenantService;
use App\Models\Tenant;
use App\Models\User;
use App\Models\BasicSetting as BS;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;

class SaaSTenantController extends Controller
{
    protected $saasService;

    public function __construct(SaaSTenantService $saasService)
    {
        $this->saasService = $saasService;
    }

    /**
     * Display the tenant creation form
     */
    public function create(): View
    {
        $data['bs'] = BS::first();
        return view('admin.saas.create-tenant', $data);
    }

    /**
     * Store a new tenant
     */
    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'username' => 'nullable|string|max:255|unique:users',
            'domain' => 'nullable|string|max:255|unique:domains,domain',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $result = $this->saasService->createTenantWithUser(
                $request->only(['fname', 'lname', 'email', 'password', 'username']),
                $request->domain
            );

            return redirect()->route('admin.tenants.index')
                ->with('success', 'Tenant created successfully! Domain: ' . $result['domain']);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to create tenant: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display all tenants
     */
    public function index(): View
    {
        $data['bs'] = BS::first();
        $data['tenants'] = Tenant::with(['owner', 'domains'])->paginate(15);
        return view('admin.saas.tenants', $data);
    }

    /**
     * Display tenant details
     */
    public function show(string $tenantId): View
    {
        $data['bs'] = BS::first();
        $data['tenant'] = Tenant::with(['owner', 'users', 'domains'])->findOrFail($tenantId);
        return view('admin.saas.tenant-details', $data);
    }

    /**
     * Add user to tenant
     */
    public function addUser(Request $request, string $tenantId): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'username' => 'nullable|string|max:255|unique:users',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $user = $this->saasService->addUserToTenant(
                $tenantId,
                $request->only(['fname', 'lname', 'email', 'password', 'username'])
            );

            return redirect()->back()
                ->with('success', 'User added to tenant successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to add user: ' . $e->getMessage());
        }
    }

    /**
     * Update tenant domain
     */
    public function updateDomain(Request $request, string $tenantId): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'domain' => 'required|string|max:255|unique:domains,domain',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $this->saasService->updateTenantDomain($tenantId, $request->domain);
            return redirect()->back()
                ->with('success', 'Domain updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update domain: ' . $e->getMessage());
        }
    }

    /**
     * Delete tenant
     */
    public function destroy(string $tenantId): RedirectResponse
    {
        try {
            $this->saasService->deleteTenant($tenantId);
            return redirect()->route('admin.tenants.index')
                ->with('success', 'Tenant deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to delete tenant: ' . $e->getMessage());
        }
    }

    /**
     * Get tenant by domain (API endpoint)
     */
    public function getByDomain(Request $request): JsonResponse
    {
        $tenant = $this->saasService->getTenantByDomain($request->domain);
        
        if (!$tenant) {
            return response()->json(['error' => 'Tenant not found'], 404);
        }

        return response()->json([
            'tenant' => $tenant,
            'owner' => $tenant->owner,
            'users_count' => $tenant->users()->count(),
            'domain' => $tenant->domains()->first()->domain
        ]);
    }
}
