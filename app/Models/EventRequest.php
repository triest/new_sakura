<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class EventRequest extends Model
    {
        //
        protected $table = "request";

        public static function getItem(int $id){
            return EventRequest::select(["*"])->where('id', $id)->first();
        }

        public function denied(){
            $this->status = "denied";
            $this->save();
        }
    }
