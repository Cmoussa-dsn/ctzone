<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    

    
    public function boot(): void
    {
        // Disable Vite to prevent manifest errors
        if (!file_exists(public_path('build/manifest.json'))) {
            \Illuminate\Foundation\Vite::macro('useBuildDirectory', function () {
                return $this;
            });
            
            \Illuminate\Foundation\Vite::macro('useHotFile', function () {
                return $this;
            });
            
            \Illuminate\Foundation\Vite::macro('useIntegrityKey', function () {
                return $this;
            });
            
            \Illuminate\Foundation\Vite::macro('withEntryPoints', function () {
                return $this;
            });
        }
    }
}
