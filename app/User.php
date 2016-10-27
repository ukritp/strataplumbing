<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Job;
class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    // Many to Many Relationship - User has many roles
    public function roles()
    {
        return $this->belongsToMany('App\Role', 'user_roles', 'user_id', 'role_id');
    }

    // check if the user has any role
    public function hasAnyRole($roles)
    {
        // if roles is array
        if(is_array($roles)){
            foreach($roles as $role){
                if($this->hasRole($role)){
                    return true;
                }
            }
        // just one variable
        }else{
            if($this->hasRole($role)){
                return true;
            }
        }
        return false;
    }

    // check if the user actually has role that match database
    public function hasRole($role)
    {
        if( $this->roles()->where('name',$role)->first() ){
            return true;
        }
        return false;
    }


    public function pendingInvoiceGroupByPM($pm)
    {
        return Job::where('approval_status', 'pending')->where('project_manager', $pm)->get();
    }

    public function invoiceApprovedOrDeclined($status)
    {
        return Job::where('approval_status', $status)->get();
    }
}
