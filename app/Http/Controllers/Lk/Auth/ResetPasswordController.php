<?php

namespace App\Http\Controllers\Lk\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function redirectPath()
    {
        return route('lk.home');
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('lk.auth.passwords.reset', ['token' => $token]);
    }

    protected function guard()
    {
        return \Auth::guard('lk');
    }

    public function broker()
    {
        return \Password::broker('users');
    }

}
