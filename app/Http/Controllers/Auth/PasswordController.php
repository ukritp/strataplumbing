<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;
    /**
     * Where to redirect users after Reset Password.
     *
     * @var string
     */
    protected $redirectTo = '/technicians/index/0';
    // redirect users based on their role
    protected function authenticated($request, $user)
    {
        $user_role = $user->roles()->first();
        // if users are admin or Owner, go to home page
        if($user_role->name === 'Admin' || $user_role->name === 'Owner') {
            return redirect('/');
        }
        // technicians
        return redirect('/technicians/index/0');
    }


    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware());
    }
}
