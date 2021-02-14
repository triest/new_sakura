<?php

namespace App\Models;

use App\Models\Lk\User;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Symfony\Component\Filesystem\Exception\IOException;

class City extends Model
{
    //
    protected $table = "cities_api";

    public static function getCurrentCity()
    {
        if (session('city')) {
            return \session('city');
        }


        $ip = \Request::ip();

        if($ip=="127.0.0.1"){
            $ip="";
        }


        $ipCity=IpCity::select(['id','ip','city_id'])->with('city')->where('ip',$ip)->first();

        if(!$ipCity) {
            // create curl resource
            $ch = curl_init();
            // set url
            curl_setopt($ch, CURLOPT_URL, "http://api.sypexgeo.net/json/" . $ip);

            //return the transfer as a string
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            // $output contains the output string
            $output = curl_exec($ch);

            if (curl_errno($ch)) {
                $error_msg = curl_error($ch);
                return null;
            }
            curl_close($ch);

            $json = json_decode($output, true);

            if (isset($json['city']['okato'])) {
                $okato = $json['city']['okato'];
            } else {
                $okato = null;
            }


            if (isset($json['city']['name_ru'])) {
                $name = $json['city']['name_ru'];
            } else {
                $name = null;
            }

            if (isset($json['region']['name_ru'])) {
                $region_name = $json['region']['name_ru'];
            } else {
                $region_name = null;
            }


            $region = Region::select(['*'])->where('name', '=', $region_name)->first();

            if (!$region && $region_name) {
                $region = new Region();
                $region->name = $region_name;
                $region->save();
            }


            $city = City::select(
                    [
                            'id',
                            'name',
                            'OKATO',
                            'region_id'
                    ]
            )->with('region')->where('OKATO', '=', intval($okato))->first();

            if (!$city) {
                $city = new City();
                $city->name = $name;
                $city->OKATO = $okato;
                $city->region_id = $region->id;
                $city->save();

                $city = City::select(
                        [
                                'id',
                                'name',
                                'OKATO',
                                'region_id'
                        ]
                )->with('region')->where('id', '=', $city->id)->first();
            }

            $user = Auth::user();
            if ($user != null) {
                if (isset($city->id)) {
                    $user->city_id = $city->id;
                }
                if (isset($region->id)) {
                    $user->region_id = $region->id;
                }
                $user->save();
            }


            if (isset($json['ip'])) {
                $ipCity = IpCity::select(['id', 'ip', 'city_id'])->with('city')->where('ip', $json['ip'])->first();

                if (!$ipCity) {
                    $ipCity = new IpCity();
                }
                $ipCity->ip = $json['ip'];
            } else {
                $ipCity = new IpCity();
                $ipCity->ip = $ip;
            }

         //   $ipCity->city()->associate($city);
            $ipCity->city_id=$city->id;
            $ipCity->save();
        }else{
            $city=$ipCity->city()->first();
            if($city){
                $region=$city->region()->first();
            }else{
                $city=null;
                $region=null;
            }
        }

        if ($city) {
            session(['city' => $city]);
            session(['region' => $region]);
        }

        return $city;
    }

    public static function get($id)
    {
        $city = City::find($id);

        return $city;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'city_id');
    }

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id');
    }

    public function ip()
    {
            return $this->hasMany(IpCity::class,'id','city_id');
    }

    public function newCity(
            Request $request
    ) {
        $validatedData = $request->validate(
                [
                        'city' => 'required',
                ]
        );

        $city = $request->city;

        if ($city == null) {
            return redirect('/anket');
        } else {
            $request->session()->put('city', $request->city);

            return redirect('/anket');
        }
    }







}
