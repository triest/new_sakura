<?php

namespace App\Http\Controllers;

use app\models\lk\User;
use App\Service\PanelService;
use http\Env\Response;
use Illuminate\Support\Facades\Auth;

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


    public function index()
    {

        $user=Auth::user();

        if($user!=null){
            return redirect('/anket');
        }

        return view('home');
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
        return view('chat');
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
