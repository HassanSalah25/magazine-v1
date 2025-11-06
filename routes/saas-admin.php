<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SaaSAdminController;

/*
|--------------------------------------------------------------------------
| SaaS Admin Routes
|--------------------------------------------------------------------------
|
| These routes handle the SaaS admin interface for managing tenants.
| This is a separate admin system for multi-tenant management.
|
*/

// Public routes (no authentication required)
Route::get('/saas-admin', function () {
    return redirect()->route('saas-admin.login');
});
Route::get('/saas-admin/login', [SaaSAdminController::class, 'showLogin'])->name('saas-admin.login');
Route::post('/saas-admin/login', [SaaSAdminController::class, 'login'])->name('saas-admin.login');

// Protected routes (authentication required)
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/saas-admin', [SaaSAdminController::class, 'dashboard'])->name('saas-admin.dashboard');
    Route::get('/saas-admin/dashboard', [SaaSAdminController::class, 'dashboard'])->name('saas-admin.dashboard');
    
    // Tenant Management
    Route::get('/saas-admin/tenants', [SaaSAdminController::class, 'indexTenants'])->name('saas-admin.tenants.index');
    Route::get('/saas-admin/tenants/create', [SaaSAdminController::class, 'createTenant'])->name('saas-admin.tenants.create');
    Route::post('/saas-admin/tenants', [SaaSAdminController::class, 'storeTenant'])->name('saas-admin.tenants.store');
    Route::get('/saas-admin/tenants/{tenantId}', [SaaSAdminController::class, 'showTenant'])->name('saas-admin.tenants.show');
    Route::post('/saas-admin/tenants/{tenantId}/users', [SaaSAdminController::class, 'addUserToTenant'])->name('saas-admin.tenants.add-user');
    Route::put('/saas-admin/tenants/{tenantId}/domain', [SaaSAdminController::class, 'updateTenantDomain'])->name('saas-admin.tenants.update-domain');
    Route::delete('/saas-admin/tenants/{tenantId}', [SaaSAdminController::class, 'deleteTenant'])->name('saas-admin.tenants.delete');
    
    // Logout
    Route::post('/saas-admin/logout', [SaaSAdminController::class, 'logout'])->name('saas-admin.logout');
});
