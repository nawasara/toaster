<?php

namespace Nawasara\Toaster;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class ToasterServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/toaster.php', 'toaster');
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'nawasara-toaster');
        
        $this->publishes([
            __DIR__.'/../config/toaster.php' => config_path('toaster.php'),
        ], 'toaster-config');
        
        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/nawasara-toaster'),
        ], 'toaster-views');
        
        // $this->publishes([
        //     __DIR__.'/../public' => public_path('vendor/nawasara-toaster'),
        // ], 'toaster-assets');

        // Publish assets ke public Laravel root
        $this->publishes([
            __DIR__.'/../public' => public_path('vendor/nawasara-toaster'),
        ], 'toaster-assets');

        Blade::componentNamespace('Nawasara\\Toaster\\View\\Components', 'nawasara-toaster');
    }
}