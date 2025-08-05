<?php

namespace App\Providers;

// ADD THESE 'use' STATEMENTS AT THE TOP OF THE FILE:


use App\Auth\ApiUserProvider; // <-- Import from the new location
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends ServiceProvider
{
    // ...
    public function boot(): void
    {
        $this->registerPolicies();

        // Register the custom provider.
        Auth::provider('api-sso', function ($app, array $config) {
            // We just need to return a new instance of our provider class.
            return new ApiUserProvider();
        });
    }
}

