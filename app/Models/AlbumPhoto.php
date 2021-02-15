<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class AlbumPhoto extends Model
    {
        //
        protected $table = "albums_photo";

        public $appends=['created'];

        public static function get($id){
            return AlbumPhoto::select(['*'])->where(['id'=>$id])->first();
        }

        public function album(){
            return $this->belongsTo(Album::class);
        }

        public function getCreatedAttribute(){
            return $this->created_at->format('Y-m-d H:i:s');

          //  return  date('Y-m-d H:i:s', 1541843467);
        }
    }
