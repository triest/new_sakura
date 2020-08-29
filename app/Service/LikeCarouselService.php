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

            if (isset($userAuth) && $userAuth != null) {
                $girls = collect(DB::select('select users.id  from users users
where users.id not in (
select likes.target_id from likes where likes.who_id=?
)
order by rand()
limit 1', [$userAuth->id]))->first();
            } else {
                $city = City::getCurrentCity();
                if ($city == null) {
                    return null;
                }
                $girls = collect(DB::select('select users.id  from users users
where users.id not in (
select likes.target_id from likes 
)
order by rand()
limit 1'))->first();
            }

            $user = User::get($girls->id);

            return $user;
        }
    }