<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

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
        return 'dpi';
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        if ( Auth::attempt([ 'dpi' => $request->dpi, 'password' => $request->password ]) ) {

            if ( !Auth::user()->acreditacion ) {

                Auth::logout();

                return back()->with('credentials', 'El usuario no está acreditado.');
            }

            return Redirect::route('home');
        }

        return back()->with('credentials', 'Las credenciales no existen.');
    }
}
