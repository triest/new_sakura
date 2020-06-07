<?php

namespace App\Http\Controllers\Lk\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $guard = 'lk';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectPath()
    {
        return route('lk.home');
    }

    public function showLoginForm()
    {
        return view('lk.auth.login');
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();
        return redirect()->route('lk.login');
    }

}
