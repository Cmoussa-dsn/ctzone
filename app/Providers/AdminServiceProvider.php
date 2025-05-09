<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminDashboardController;

class AdminServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Explicitly bind the AdminController and AdminDashboardController
        $this->app->bind('AdminController', function ($app) {
            return new AdminController();
        });
        
        $this->app->bind('AdminDashboardController', function ($app) {
            return new AdminDashboardController();
        });
        
        // Bind 'admin' to AdminController for middleware
        $this->app->bind('admin', function($app) {
            return new AdminController();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
} 