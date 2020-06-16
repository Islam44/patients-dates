<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Sd;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    public function username()
    {
        $login = request()->login;
        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';
        request()->merge([$fieldType => $login]);
        return $fieldType;
    }

    protected function authenticated(Request $request, User $user)
    {
        if ($user->user_type->role==Sd::$doctorRole) {
            return redirect('/home')->with('message', 'welcome doctor '.$user->name);

        }
        else if ($user->user_type->role==Sd::$adminRole) {
            return redirect('/home')->with('message', 'welcome Admin '.$user->name);

        }
        else  {
            return redirect('/home')->with('message', 'welcome User '.$user->name);

        }

    }

    }
