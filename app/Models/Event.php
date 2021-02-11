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

    public static function inMyCity($city = null, $date = null)
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
                    ->get();
        } else {
            return null;
        }
    }

    public function checkUserPartification($user = null)
    {
        if ($user == null) {
            $user = Auth::user();
        }

        if ($user == null) {
            return false;
        }

        $partificatpr = DB::table('request')->select('*')
                ->where('name', 'event')
                ->where('who_id', '=', $user->id)
                ->where('target_id', '=', $this->id)
                ->get();

        return $partificatpr;
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
}
