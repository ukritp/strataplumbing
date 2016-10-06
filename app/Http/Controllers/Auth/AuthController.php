<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Role;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;


    protected $maxLoginAttempts = 5; // Amount of bad attempts user can make
    protected $lockoutTime = 300; // Time for which user is going to be blocked in seconds


    /**
     * Where to redirect users after login / registration.
     * point to technician page because the default role is Technician
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
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
        // attach a default role to new registra to be Technicians
        $user->roles()->attach(Role::where('name','Technician')->first());

        return $user;

        // ORIGINAL CODE ----------------------------
        // return User::create([
        //     'name' => $data['name'],
        //     'email' => $data['email'],
        //     'password' => bcrypt($data['password']),
        // ]);
    }
}
