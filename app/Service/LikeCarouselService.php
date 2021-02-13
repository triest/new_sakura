<?php
    /**
     * Created by PhpStorm.
     * User: triest
     * Date: 29.08.2020
     * Time: 11:20
     */

    namespace App\Service;


    use App\Models\City;
    use App\Models\Lk\User;
    use Illuminate\Support\Facades\DB;

    class LikeCarouselService
    {

        public function getAnket($userAuth = null)
        {

            $user=User::select(['*']);

            $city=City::getCurrentCity();

            if ($city == null) {
                return null;
            }

            $user->where('city_id','=',$city->id);

            $user->with(['target','relation','interest']);

            $user=$user->inRandomOrder();

            return $user->first();
        }
    }
