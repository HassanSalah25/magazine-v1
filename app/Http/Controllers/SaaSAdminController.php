<?php

namespace App\Http\Controllers;

use App\Services\SaaSTenantService;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SaaSAdminController extends Controller
{
    protected $saasService;

    public function __construct(SaaSTenantService $saasService)
    {
        $this->saasService = $saasService;
    }

    /**
     * Show SaaS admin login form
     */
    public function showLogin(): View
    {
        return view('saas-admin.auth.login');
    }

    /**
     * Handle SaaS admin login
     */
    public function login(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('saas-admin.dashboard'));
        }

        return redirect()->back()
            ->withErrors(['email' => 'Invalid credentials'])
            ->withInput();
    }

    /**
     * Show SaaS admin dashboard
     */
    public function dashboard(): View
    {
        $tenants = Tenant::with(['owner', 'domains'])->paginate(15);
        $totalTenants = Tenant::count();
        $totalUsers = User::whereNotNull('tenant_id')->count();
        
        return view('saas-admin.dashboard', compact('tenants', 'totalTenants', 'totalUsers'));
    }

    /**
     * Show tenant creation form
     */
    public function createTenant(): View
    {
        return view('saas-admin.tenants.create');
    }

    /**
     * Store a new tenant
     */
    public function storeTenant(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'username' => 'nullable|string|max:255|unique:users',
            'subdomain' => 'nullable|string|max:255|regex:/^[a-zA-Z0-9-]+$/',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $result = $this->saasService->createTenantWithUser(
                $request->only(['fname', 'lname', 'email', 'password', 'username']),
                $request->subdomain
            );

            return redirect()->route('saas-admin.tenants.index')
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
    public function indexTenants(): View
    {
        $tenants = Tenant::with(['owner', 'domains'])->paginate(15);
        return view('saas-admin.tenants.index', compact('tenants'));
    }

    /**
     * Display tenant details
     */
    public function showTenant(string $tenantId): View
    {
        $tenant = Tenant::with(['owner', 'users', 'domains'])->findOrFail($tenantId);
        return view('saas-admin.tenants.show', compact('tenant'));
    }

    /**
     * Add user to tenant
     */
    public function addUserToTenant(Request $request, string $tenantId): RedirectResponse
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
    public function updateTenantDomain(Request $request, string $tenantId): RedirectResponse
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
    public function deleteTenant(string $tenantId): RedirectResponse
    {
        try {
            $this->saasService->deleteTenant($tenantId);
            return redirect()->route('saas-admin.tenants.index')
                ->with('success', 'Tenant deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to delete tenant: ' . $e->getMessage());
        }
    }

    /**
     * Logout SaaS admin
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('saas-admin.login');
    }
}
