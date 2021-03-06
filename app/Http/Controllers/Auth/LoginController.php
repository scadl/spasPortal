<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // To control users status,
    // overwrite original function on Illuminate\Foundation\AuthAuthenticatesUsers:
    protected function credentials(Request $request)
    {
        return array_merge($request->only($this->username(), 'password'),['isEnabled'=>true]);
    }

    // Add some logic, if The user has been authenticated.
    protected function authenticated(Request $request, $user)
    {
        $user->numLogin += 1;
        $user->save();
    }
}
