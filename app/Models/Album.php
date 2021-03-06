<?php

    namespace App\Models;

    use App\Models\Lk\User;
    use Illuminate\Database\Eloquent\Model;
    use App\Models\AlbumPhoto as AlbumPhoto;
    use Illuminate\Support\Facades\Auth;

    class Album extends Model
    {
        //
        protected $table = "albums";

        public function user()
        {
            return $this->belongsTo(User::class);
        }

        public function getCover()
        {
            $item = $this->Photos()->first();


            if ($item) {
                return $item->url;
            } else {
                return "upload/no_avatar.gif";
            }
        }

        public function Photos()
        {
            return $this->hasMany(AlbumPhoto::class);
        }

        public function countPhotos()
        {
            return $this->Photos()->count();
        }

        public function canUpload()
        {
            if (Auth::user() && $this->user()->first()!=null && Auth::user()->id == $this->user()->first()->id) {
                return true;
            } else {
                return false;
            }
        }

        public static function getItem($id){
            return Album::select(['*'])->where('id',$id)->first();
        }
    }
