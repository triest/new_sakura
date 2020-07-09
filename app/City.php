<?php

    namespace App;

    use App\Models\Lk\User;
    use http\Env\Request;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Session;
    use Symfony\Component\Filesystem\Exception\IOException;

    class City extends Model
    {
        //
        protected $table = "cities_api";

        public static function GetCurrentCity()
        {
            $ip = User::getIpStatic();
            $response = file_get_contents("http://api.sypexgeo.net/json/" . $ip);
            $response = json_decode($response);
            $okato = $response->city->okato;
            $city = City::select([
                    'id',
                    'name',
                    'OKATO',
            ])->where('OKATO', '=', intval($okato))->first();


            if ($city == null) {
                $name = $response->city->name_ru;
                $response
                        = file_get_contents("https://kladr-api.ru/api.php?contentType=city&withParent=1&limit=10&query=$name");
                $response = json_decode($response);
                $result = $response->result;
                $city = City::select([
                        'id',
                        'name',
                        'OKATO',
                ])->where('OKATO', $okato)->first();
                if ($city == null) {
                    $city = new  City();
                    $city->name = $result[1]->name;
                    $city->OKATO = substr($result[1]->okato, 0, 8);
                    $city->PARANTS_OKATO = $result[1]->parents[0]->okato;
                    $city->save();
                }

                return $city;
            } else {
                return $city;
            }
        }

        public static function get($id)
        {
            $city = City::select(['*'])->where('id', $id)->first();

            return $city;
        }

        public function user()
        {
            return $this->belongsTo('App\User', 'city_id');
        }


        public function newCity(
                Request $request
        ) {
            $validatedData = $request->validate([
                    'city' => 'required',
            ]);

            $city = $request->city;

            if ($city == null) {
                return redirect('/anket');
            } else {
                $request->session()->put('city', $request->city);

                return redirect('/anket');
            }

        }



        public function changeCity()
        {
            $city = Session::get('city');
            $city = DB::table('cities')->where('id_city', $city)->first();

            return view('changeCity')->with(['city' => $city]);
        }

        public static function findcity($name)
        {
            //echo $name;
            $cities = DB::table('cities')->where('name', 'like', $name . '%')->get();

            return response()->json([$cities]);
        }

        public static function findcity2($name)
        {
            /*
             * 1) Ищим по имени в таблице
             *
             * 2) Если нет, то шлем запрос на api
             *
             * 3) Добавляем в таблицу
            */
            $cities = DB::table('cities_api')->where('name', 'like', '%' . $name . '%')
                    ->get();


            if ($cities->isEmpty()) {
                $response
                        = file_get_contents("https://kladr-api.ru/api.php?contentType=city&withParent=1&limit=10&query=$name");
                $response = json_decode($response);
                $result = $response->result;

                $cities = DB::table('cities_api')
                        ->where('OKATO', 'like', '%' . $result[1]->oktmo . '%')
                        ->get();

                if ($cities->isEmpty()) {
                    DB::table('cities_api')->insert(
                            [
                                    'name' => $result[1]->name,
                                    'OKATO' => $result[1]->oktmo,
                                    'PARANTS_OKATO' => $result[1]->parents[0]->okato,
                            ]
                    );
                    $cities = DB::table('cities_api')
                            ->where('name', 'like', $name . '%')
                            ->get();
                }
            }

            return response()->json($cities);
        }

    }