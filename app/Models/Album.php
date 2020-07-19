<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;
    use App\AlbumPhoto as AlbumPhoto;

    class Album extends Model
    {
        //
        protected $table = "albums";

        public function user()
        {
            return $this->belongsTo("user");
        }

        public function getCover()
        {
            $item = $this->Photos()->first();

            if ($item != null) {
                return $item;
            } else {
                return "no_avatar.gif";
            }
        }

        public function Photos()
        {
            return $this->hasMany(AlbumPhoto::class);
        }

        public function coutPhotos()
        {
            return $this->Photos()->count();
        }
    }
