<?php

    namespace App\Http\Controllers;

    use App\Models\Lk\User;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Cookie;

    class AnketController extends Controller
    {
        // создание каталогов
        function _create_dir($patch = '')
        {
            if (empty($patch)) {
                return false;
            }

            $dir = explode('/', $patch);
            $pp = '';
            foreach ($dir as $k => $v) {
                if ($k) {
                    $pp .= '/';
                }

                $pp .= $v;
                if (!file_exists($pp)) {
                    mkdir($pp);
                }
            }
        }

        public function index(Request $request)
        {

            if (!isset($_COOKIE["carousel"])) {
                Cookie::queue("carousel", AnketController::randomString(), 30);
                return redirect('/like-carousel');
            }

            return view("anket.index");
        }

        public function visits(Request $request){

            return view('anket.visits');
        }

        public function apiVisits(Request $request){
            $user=Auth::user();
            if($user==null){
                return null;
            }

       //    $visits=$user->whoVisit()->with('who')->distinct('who_id')->groupBy('who_id','id','target_id')->get();
            $visits=$user->getVisits();


            return  response()->json($visits);
        }

        //
        public function view(Request $request, $id)
        {
            $user=User::select(['id','name','age','sex','description','city_id','relation_id','photo_profile_url'])->where('id', $id)->with('target','interest','like','relation','city','GiftForMe')->first();

            if(!$user){
                abort(404);
            }

            return view('anket.view')->with([
                    'user' => $user,
            ]);
        }

        public static function randomString($length = 64)
        {
            $chars = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
            $str = "";

            for ($i = 0; $i < $length; $i++) {
                $str .= $chars[mt_rand(0, strlen($chars) - 1)];
            }

            $str = substr(base64_encode(sha1(mt_rand())), 0, $length);

            return $str;
        }


    }
