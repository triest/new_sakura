<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class AlbumPhoto extends Model
    {
        //
        protected $table = "albums_photo";

        public static function get($id){
            return AlbumPhoto::select(['*'])->where(['id'=>$id])->first();
        }

        public function album(){
            return $this->belongsTo(Album::class);
        }
    }
