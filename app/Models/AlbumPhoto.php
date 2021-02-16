<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class AlbumPhoto extends Model
    {
        //
        protected $table = "albums_photo";

        public $appends=['created','user'];

        public static function get($id){
            return AlbumPhoto::select(['*'])->where(['id'=>$id])->first();
        }

        public function album(){
            return $this->belongsTo(Album::class);
        }

        public function getCreatedAttribute(){

            if($this->created_at->isToday()){
                return "сегодня";
            }elseif ($this->created_at->isYesterday()){
                return "вчера";
            }
            //$data=$this->created_at->format('Y-m-d H:i:s');

            $data= $this->created_at->subMonth()->format('F');

            return $data;

          //  return  date('Y-m-d H:i:s', 1541843467);
        }

        public function getUserAttribute(){
             $album=$this->album()->first();
             if(!$album){
                 return null;
             }
             return $album->user()->first();
        }
    }
