<?php

namespace App\Models;

use App\EventStatus;
use App\Models\Lk\User;
use Carbon\Carbon;
use Doctrine\DBAL\Events;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Event extends Model
{
    //
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function inMyCity(City $city = null, $date = null)
    {
        if ($city == null) {
            $city = City::getCurrentCity();
        }

        if ($date == null) {
            $date = Carbon::now()->toDateTimeString();
        }

        if ($city != null) {
            return $events = Event::select(['*'])
                    ->where('city_id', $city->id)
                    ->where('begin', '>', $date)
                    ->where(function ($q){
                        $q->orWhere('status_id',2)
                                ->orWhere('status_id',3)
                                ->orWhere('status_id',4);
                    })
                    ->with('status')
                    ->get();
        } else {
            return null;
        }
    }

    public function checkUserParticipation($user = null)
    {
        if ($user == null) {
            $user = Auth::user();
        }

        if ($user == null) {
            return false;
        }

        return $this->request()->where('user_id', $user->id)->with('status')->first();
    }

    public static function get($id)
    {
        return Event::select(["*"])->where("id", $id)->first();
    }

    public function status()
    {
        return $this->hasOne(EventStatus::class,'id','status_id');
    }

    public function request(){
            return $this->hasMany(EventRequest::class);
    }

    public function makeRequest(User $user=null){
        if(!$user){
            $user=Auth::user();
        }

        if(!$user){
           return "not user";
        }

        $eventRequwest = new EventRequest();
        $eventRequwest->user_id = $user->id;
        $eventRequwest->event_id = $this->id;
        $eventRequwest->status_id=1;
        $eventRequwest->save();
        return EventRequest::select(['*'])->with('status')->where('id',$eventRequwest->id)->first();

    }
}
