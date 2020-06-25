<?php

    namespace App;

    use Carbon\Carbon;
    use Doctrine\DBAL\Events;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\DB;

    class Event extends Model
    {
        //
        public function user()
        {
            return $this->belongsTo("user");
        }

        public static function inMyCity($city = null, $date = null)
        {
            if ($city == null) {
                $city = City::GetCurrentCity();
            }

            if ($date == null) {
                $date = Carbon::now()->toDateTimeString();
            }

            if ($city != null) {
                return $events = Event::select(['*'])
                        ->where('city_id', $city->id)
                        ->where('begin', '>', $date)
                        ->get();
            } else {
                return null;
            }

        }

        public function checkUserPartification($user = null)
        {
            //   dump($user);
            if ($user == null) {
                $user = Auth::user();
            }

            if ($user == null) {
                return false;
            }
            /*
                    $partificatpr = DB::table('event_requwest')->select('*')
                            ->where('girl_id', '=', $anket->id)
                            ->where('event_id', '=', $this->id)
                            ->get();
            */
            return null;
        }

        public static function get($id)
        {
            return Event::select(["*"])->where("id", $id)->first();
        }
    }
