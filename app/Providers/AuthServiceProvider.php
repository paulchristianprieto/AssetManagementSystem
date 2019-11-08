<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Asset;
use App\Category;
use App\Vendor;
use App\User_request;
use App\Policies\UserRequestPolicy;
use App\Policies\AssetPolicy;
use App\Policies\CategoryPolicy;
use App\Policies\VendorPolicy;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
        Asset::class => AssetPolicy::class,
        Category::class => CategoryPolicy::class,
        Vendor::class => VendorPolicy::class,
        User_request::class => UserRequestPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('isAdmin', function($user){
            return $user->role_id === 1;
        });

        Gate::define('isUser', function($user){
            return $user->role_id;
        });
    }
}
