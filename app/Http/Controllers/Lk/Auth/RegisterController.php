<?php

namespace App\Http\Controllers\Lk\Auth;

use App\Http\Requests\RCreauteUser;
use App\Models\Lk\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    use RegistersUsers;


    public function redirectPath()
    {
        return route('lk.home');
    }


    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return \App\Models\Lk\User
     */
    protected function create(array $data)
    {
        //    die("ds");
        $user = User::create([
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
        ]);

        return $user;
        return redirect(route('lk.profile'));
    }

    public function join(RCreauteUser $request)
    {

        $user = User::create([
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
        ]);

        if (!$user) {
            return null;
        }
        Auth::login($user);
     //   $user->login();

        return redirect(route('lk.profile'));
    }


    public function showRegistrationForm()
    {
        return view('lk.auth.register');
    }
}
