<?php

    namespace App\Http\Controllers;

    use App\Http\Requests\AlbumRequwest;
    use App\Http\Resources\AlbumPhotosResourse;
    use App\Models\Album;
    use App\Models\AlbumPhoto;
    use App\Models\Lk\User;
    use App\Service\AlbumService;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use phpDocumentor\Reflection\Types\Collection;

    class AlbumController extends Controller
    {
        //

        private $albumService = null;

        private $user = null;


        public function albums($id, Request $request)
        {
            $user = User::get($id);
            if(!$user){
                abort(404);
            }
            $albumsService=new AlbumService();
            $albumsService->setUser($user);

            $albums=$albumsService->getAlbums();

            return view("anket.albums")->with(["user" => $user, "albums" => $albums]);
        }

      public function apiAlbumOwner($albumid,$anketid){
          $authUser=Auth::user();


          $album=Album::getItem($anketid);
          if(!$album){
              abort(404);
          }

          if($authUser!=null && $album->user_id==$authUser->id){
              $owner=true;
          }else{
              $owner=false;
          }

          $photos=$album->photos()->get();

          return response()->json(['photos'=>$photos,'owner'=>$owner]);
      }

        public function albumItem($id, $albumid, Request $request)
        {
            $user = User::get($id);
            $albumsService=new AlbumService();

            $album=Album::getItem($albumid);
            if(!$album){
                abort(404);
            }

            $albums = $user->albums()->get();
            if ($albums->isEmpty()) {
                $album = new Album();
                $album->name = "Основной альбом";
                $album->save();
                $this->user->albums()->save($album);
                $albums->push($album);
            }

            $photos = $album->photos()->get();
            $user = User::get($id);

            return view("anket.album")->with(["album" => $album, "user" => $user]);
        }

        public function apiAlbumItem($albumid,$anketid){

            $authUser=Auth::user();


            $album=Album::getItem($anketid);
            if(!$album){
                abort(404);
            }

            if($authUser!=null && $album->user_id==$authUser->id){
                $owner=true;
            }else{
                $owner=false;
            }

            $photos=$album->photos()->get();

            $arr=[];
            foreach ($photos as $photo){
                $arr[]=  url('/')."/".$photo->url;
            }

            return response()->json($arr);
        //   return AlbumPhotosResourse::collection($photos);
        }

        public function uploadPhoto($id, $albumid,AlbumRequwest $requwest)
        {
            $user = User::get($id);
            $album=Album::getItem($albumid);
            $albumService=new AlbumService($user);
            $image=$requwest->file('image');
            $albumService->image=$image;
            $alpumPhoto=$albumService->uploadAlbumImage($album);

           return response()->json(['photo' => $alpumPhoto]);
        }

        public function deletePhoto(Request $request,$id,$albumid,$photoid){


            $user=Auth::user();
            $photo=AlbumPhoto::get($photoid);

            if(!$photo){
                return false;
            }
            $album=$photo->album()->first();
            $albumService=new AlbumService();

            return  $albumService->deletePhoto($photo);
        }


    }
