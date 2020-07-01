<?php

    namespace App\Http\Controllers\Auth;

    use App\City;
    use App\Http\Controllers\Controller;
    use App\Providers\RouteServiceProvider;
    use Carbon\Carbon;
    use Illuminate\Foundation\Auth\AuthenticatesUsers;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\DB;

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
7
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



        function authenticated(Request $request, $user)
        {
            //тут когда последний раз заходил
            $user = Auth::user();
            if ($user != null) {
                DB::table('users')
                        ->where('id', $user->id)
                        ->update(['last_login' => Carbon::now()->toDateTimeString()]);

                $city = City::GetCurrentCity();

                if ($user != null && $city != null) {
                    $user->city_id = $city->id;
                    $user->save();
                }
            }

        }
    }
