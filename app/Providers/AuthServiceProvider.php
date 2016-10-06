<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

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
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        // If user's role is Admin or Owner, they can do anything
        // If user's role is Technician, they can only edit their own Technician details
        $gate->define('technician-gate', function ($user, $technician) {
            // echo $user->id;
            // echo $technician->user_id;
            if ($user->roles()->first()->name === 'Technician') {
                return $user->id == $technician->user_id;
            }else{
                return true;
            }
        });
    }
}
