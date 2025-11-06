<?php

namespace App\Providers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $menuJson = File::get(resource_path('data/admin_menu.json'));
            $menuItems = collect(json_decode($menuJson, true))->map(function ($item) {
                $item['active'] = request()->routeIs(@$item['route']);
                return $item;
            });

            $view->with('adminMenu', $menuItems);
        });
    }
}
