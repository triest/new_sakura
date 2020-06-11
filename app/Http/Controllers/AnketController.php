<?php

    namespace App\Http\Controllers;

    use App\Album;
    use App\AlbumPhoto;
    use App\Interest;
    use App\Models\Lk\User;
    use App\Target;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;

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


            return view('anket.view')->with([
                    'user' => $user,
                    'targets' => $target,
                    'interests' => $interst
            ]);
        }

        public function albums($id, Request $request)
        {
            $user = User::get($id);

            if ($user == null) {
                return redirect("/anket");
            }

            $albums = $user->albums()->get();
            if ($albums->isEmpty()) {
                $album = new Album();
                $album->name = "Основной альбом";
                $album->save();
                $user->albums()->save($album);
                $albums->push($album);
            }

            return view("anket.albums")->with(["user" => $user, "albums" => $albums]);
        }

        public function albumItem($id, $albumid, Request $request)
        {
            $album = Album::select(['*'])->where('id', $albumid)->first();
            $photos = $album->photos()->get();
            $user = User::get($id);

            return view("anket.album")->with(["album" => $album, "photos" => $photos, "user" => $user]);
        }

        public function uploadPhoto(Request $request)
        {
            //   dump($request);

            $user = Auth::user();
            //dump($user);

            $album = $request->input("album");
            $midle_path = 'public/upload/lk_profile/' . $user->id . '/' . 'albums/' . $album;
            $midle_path2 = '/upload/lk_profile/' . $user->id . '/' . 'albums/' . $album;


            $image_new_name = md5(microtime(true)) . ".png";;

            $request->file('image')
                    ->move(base_path() . '/' . $midle_path,
                            strtolower($image_new_name));

            //save photo
            $alpumPhoto = new AlbumPhoto();
            $alpumPhoto->name = $image_new_name;
            $alpumPhoto->album_id = $album;
            $alpumPhoto->url = $midle_path2 . "/" . $image_new_name;
            $alpumPhoto->save();

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
