<?php

namespace App\Providers;

use App\Sd;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Gate::define('admin-action', function ($user) {
            return $user->hasType(Sd::$adminRole);
        });
        Gate::define('doctor-action', function ($user) {
            return $user->hasType(Sd::$adminRole);
        });
        Gate::define('user-action', function ($user) {
            return $user->hasType(Sd::$userRole);
        });

        //
    }
}
