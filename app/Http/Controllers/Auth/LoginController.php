<?php

namespace App\Http\Controllers\Auth;

use App\Support\Util;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->username() => 'required|exists:users,' . $this->username() . ',status,1',
            'password' => 'required',
        ], [
            $this->username() . '.exists' => 'La cuenta esta inactiva o no existe.'
        ]);
    }
    
    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {        
        session(['menusValidos'=>Util::regresaRutasValidas()]);
        return redirect()->route('home');
    }

    public function logout(Request $request) {

        if(Auth::user() && Auth::user()->perfil_id == 2 ){
            //Client logout redirect

            if ($request->session()->has('MASTER_USER')) {

                Auth::logout();
                $request->session()->flush();
                $request->session()->regenerate();
                return redirect()->route('master_login');
            }else{

                Auth::logout();
                $request->session()->flush();
                $request->session()->regenerate();
                return redirect()->route('client_login');
            }
            
        }else{
            //Admin logout redirect
            Auth::logout();
            $request->session()->flush();
            $request->session()->regenerate();
            return redirect()->route('login');
        }        
    }
}
