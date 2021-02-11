<?php

namespace App\Http\Controllers;

use app\models\lk\User;
use App\Service\PanelService;
use Carbon\Carbon;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Filesystem\Exception\IOException;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home.index');
    }


    public function lesson()
    {
        return view('home.lesson');
    }

    public function city()
    {
        $city = \App\Models\City::getCurrentCity();
        //  dump($city);
    }

    public function test()
    {
        $user = User::select(['*'])->whereNull('age')->first();
        // return $user;
        if (!$user) {
            return \response()->json();
        }
        try {
            $dateBith = $user->date_birth;
            $mytime = Carbon::now();
            $last_login = Carbon::createFromFormat('Y-m-d', $dateBith);
            $dateBith = Carbon::instance($mytime);
            //    $datediff = date_diff($last_login, $mytime);
            $user->age = $dateBith->diffInYears($last_login);
            $user->save();
            return \response()->json($user);
        } catch (IOException $exception) {
            return \response()->json($exception);
        }
    }

    public function calculatAge()
    {
        $users = User::select(['*'])->whereNull('age')->limit(5)->get();
        //   dump($users);

        foreach ($users as $user) {
            $user->age = $user->getAge();
            $user->save();
        }

        return \response(200)->json(['response' => 'ok']);
    }

    protected function _error($code, $message, $msgShouldBeShow = false)
    {

        return response()->json([
                                        'success' => false,
                                        'message' => $message,
                                        'msgShouldBeShown' => $msgShouldBeShow
                                ], $code);

    }

    public function getAllDataForSidePanel(){
        $panelService=new PanelService();
        $data=$panelService->getAllData();
        return response()->json($data);
    }
}
