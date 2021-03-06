<?php

    namespace App\Http\Controllers\Auth;

    use App\Http\Controllers\Controller;
    use App\Models\City;
    use App\Providers\RouteServiceProvider;
    use Carbon\Carbon;
    use Illuminate\Foundation\Auth\AuthenticatesUsers;
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
        protected $redirectTo ='/';

        /**
         * Create a new controller instance.
         *
         * @return void
         */
        public function __construct()
        {
            $this->middleware('guest')->except('logout');
        }


        function authenticated()
        {
            //тут когда последний раз заходил
            $user = Auth::user();
            if ($user != null) {
                $user->last_login= Carbon::now()->toDateTimeString();
                $city = City::getCurrentCity();
                if ($city != null) {
                    $user->city_id = $city->id;
                }
                $user->save();
                redirect()->intended();
            }

        }
    }
