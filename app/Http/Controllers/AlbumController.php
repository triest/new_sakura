<?php

    namespace App\Http\Controllers;

    use App\Models\Album;
    use App\Models\AlbumPhoto;
    use App\Models\Lk\User;
    use App\Service\AlbumService;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;

    class AlbumController extends Controller
    {
        //

        private $albumService = null;

        private $user = null;


        /**
         * AlbumController constructor.
         */
        public function __construct(AlbumService $albumService, Request $request)
        {
            $this->albumService = $albumService;
            $this->albumService->user = Auth::user();

            $this->albumService->request=$request;
        }

        public function albums($id, Request $request)
        {
            $user = User::get($id);
            $this->albumService->setUser($user);

            if ($user == null) {
                return redirect("/anket");
            }

            return view("anket.albums")->with(["user" => $user, "albums" => $this->albumService->getAlbums()]);
        }

        public function albumItem($id, $albumid, Request $request)
        {
            $album = $this->albumService->getAlbum($albumid);
            $photos = $album->photos()->get();
            $user = User::get($id);


            return view("anket.album")->with(["album" => $album, "photos" => $photos, "user" => $user]);
        }

        public function uploadPhoto($id, $albumid, Request $request)
        {
            $album = Album::getItem(intval($albumid));
            if($album==null){
                return  response()->json([false]);
            }

            $alpumPhoto = $this->albumService->uploadAlbumImage($album);


            return response()->json(['photo' => $alpumPhoto]);
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
