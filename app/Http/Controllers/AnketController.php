<?php

    namespace App\Http\Controllers;

    use App\Models\Album;
    use App\Models\AlbumPhoto;
    use App\Models\Interest;
    use App\Models\Lk\User;
    use App\Models\Target;
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

            if (!isset($_COOKIE["causel"])) {
                Cookie::queue("causel", AnketController::randomString(), 60);

                return redirect('/like-carusel');
            }

            return view("anket.index");
        }

        //
        public function view(Request $request, $id)
        {

            $user = User::get($id);


            if ($user == null) {
                return null;
            }

            $target = Target::select(['*'])->get();

            $interst = Interest::select(['*'])->get();


            $targets = $user->target()->get();

            $anketTarget = [];
            foreach ($targets as $tag) {
                array_push($anketTarget, $tag->id);
            }

            $interests = $user->interest()->get();

            $anketInterest = [];
            foreach ($interests as $item) {
                array_push($anketInterest, $item->id);
            }

            $gifts = $user->getGifts();
            return view('anket.view')->with([
                    'user' => $user,
                    'targets' => $target,
                    'interests' => $interst,
                    'gifts' => $gifts
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
