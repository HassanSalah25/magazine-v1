<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::get('/', function () {
        $tenant = tenant();
        $userCount = \App\Models\User::count();
        $productCount = \App\Models\Product::count();
        
        return response()->json([
            'message' => 'Multi-tenant application',
            'tenant_id' => $tenant->id,
            'domain' => request()->getHost(),
            'users_count' => $userCount,
            'products_count' => $productCount,
            'table_prefix' => config('tenancy.database.prefix') . $tenant->id . config('tenancy.database.suffix'),
        ]);
    });
    
    Route::get('/users', function () {
        $users = \App\Models\User::all(['id', 'fname', 'lname', 'email']);
        return response()->json([
            'tenant_id' => tenant()->id,
            'users' => $users
        ]);
    });
    
    Route::get('/products', function () {
        $products = \App\Models\Product::all(['id', 'title', 'current_price']);
        return response()->json([
            'tenant_id' => tenant()->id,
            'products' => $products
        ]);
    });
});
