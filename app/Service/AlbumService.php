<?php
    /**
     * Created by PhpStorm.
     * User: triest
     * Date: 22.07.2020
     * Time: 19:43
     */

    namespace App\Service;


    use App\Models\Album;
    use App\Models\AlbumPhoto;
    use App\Models\Lk\User;
    use http\Env\Request;
    use Illuminate\Support\Facades\Auth;

    class AlbumService
    {
        public $user = null;

        /**
         * @param User|null $user
         */
        public function setUser(?User $user): void
        {
            $this->user = $user;
        }

        /**
         * @param Request|null $request
         */
        public function setRequest(?Request $request): void
        {
            $this->request = $request;
        }

        public $request = null;

        /**
         * AlbumService constructor.
         */
        public function __construct(User $user = null, Request $request = null)
        {
            if ($user == null) {
                $this->user = Auth::user();
            } else {
                $this->user = $user;
            }
            $this->request = $request;
        }

        public function getAlbums()
        {

            $albums = $this->user->albums()->get();
            if ($albums->isEmpty()) {
                $album = new Album();
                $album->name = "Основной альбом";
                $album->save();
                $this->user->albums()->save($album);
                $albums->push($album);
            }


            return $albums;
        }

        public function getAlbum($id)
        {
            return Album::select(['*'])->where('id', $id)->first();
        }

        public function uploadAlbumImage($album)
        {

            $this->user=   Auth::user();;
            $midle_path = 'public/upload/lk_profile/' . $this->user->id . '/' . 'albums/' . $album->id;
            $midle_path2 = '/upload/lk_profile/' .$this->user->id . '/' . 'albums/' .  $album->id;
            $image_new_name = md5(microtime(true)) . ".png";;

            $this->request->file('image')
                    ->move(base_path() . '/' . $midle_path,
                            strtolower($image_new_name));

            //save photo
            $alpumPhoto = new AlbumPhoto();
            $alpumPhoto->name = $image_new_name;
            $alpumPhoto->album_id =  $album->id;
            $alpumPhoto->url = $midle_path2 . "/" . $image_new_name;
            $alpumPhoto->save();

            return $alpumPhoto;
        }

    }