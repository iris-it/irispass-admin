<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Irisit\IrispassShared\Model\Permission;

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
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);


        foreach ($this->getPermissions() as $permission) {
            $gate->define($permission->name, function ($user) use ($permission) {
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
