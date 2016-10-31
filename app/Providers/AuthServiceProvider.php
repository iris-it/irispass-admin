<?php

namespace App\Providers;

use App\Permission;
use App\Services\Auth\JWTGuard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Auth::extend('jwt', function ($app, $name, array $config) {
            return new JWTGuard(Auth::createUserProvider($config['provider']), $app['request']);
        });

        foreach ($this->getPermissions() as $permission) {
            Gate::define($permission->name, function ($user) use ($permission) {
                if ($user->role->name == "admin") {
                    return true;
                }

                if (env('ENABLE_APP_PERMISSIONS') == true) {
                    return $user->hasPermission($permission->name);
                } else {
                    return true;
                }
            });
        }
    }

    /**
     * Retrieve ALL the permissions with eager loading
     *
     * @return mixed
     */
    protected function getPermissions()
    {
        if (Schema::hasTable('permissions')) {
            return Permission::with('roles')->get();
        }

        return [];
    }
}
