<?php

    namespace App\Models;

    use App\EventRequestStatus;
    use App\EventStatus;
    use Illuminate\Database\Eloquent\Model;
    use App\Models\Lk\User;

    class EventRequest extends Model
    {
        //
        protected $table = "event_request";

        public static function getItem(int $id){
            return EventRequest::select(["*"])->where('id', $id)->first();
        }

        public function denied(){
            $this->status_id = 3;
            $this->save();
        }

        public function accept(){
            $this->status_id = 2;
            $this->save();
        }

        public function user(){
            return $this->hasOne(User::class,'id','user_id');
        }

        public function event(){
            return $this->hasOne(User::class,'id','event_id');
        }

        public function status(){
            return $this->hasOne(EventRequestStatus::class,'id','status_id');
        }
    }
