<?php
    /**
     * Created by PhpStorm.
     * User: triest
     * Date: 05.09.2020
     * Time: 14:18
     */

    namespace App\Service;


    use App\Models\City;
    use App\Models\Lk\User;
    use App\Models\SearchSettings;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\DB;

    class SearchService
    {
        private $limit = 16;

        private $paginate=12;

        public function search()
        {
            $userAuth = Auth::user();
            if ($userAuth != null) {
                if ($userAuth != null) {
                    $seachSettings = $userAuth->seachsettings()->first();
                }
            } else {
                if (isset($_COOKIE["seachSettings"])) {
                    $cookie = $_COOKIE["seachSettings"];
                    if ($cookie != null) {
                        $seachSettings = SearchSettings::select(['*'])
                                ->where("cookie", "=", $cookie)
                                ->orderBy('updated_at', 'desc')
                                ->first();
                    }
                }

            }

            if (!isset($seachSettings) || $seachSettings == null) {

                $users = DB::table('users');
                if (isset($userAuth) && $userAuth != null) {
                    $users->where('city_id', '=', $userAuth->city_id);
                }


                $city = City::getCurrentCity();

                if ($city != null) {
                    $users->where('city_id', $city->id);
                }

                if (Auth::user() != null) {
                    $users->where('id', '!=', Auth::user()->id);
                }

                $count = $users->count();
                if (isset($_GET['page']) && intval($_GET['page']) > 1) {
                    $page = intval($_GET['page']);
                    $offset = $this->limit * ($page);
                    $users->offset($offset);
                }

                $users->select('users.id', 'users.name', 'users.profile_url', 'users.date_birth',
                        'users.created_at')->limit($this->limit);

                $num_pages = intval($count / $this->limit);
                $users->limit($this->limit);
                $users->orderByDesc('created_at')->get();
                $users = $users->paginate($this->paginate);

                return $users;
            }


            $users = User::select(['*']);

            $interest = $seachSettings->interest()->get();


            if ($interest->isNotEmpty()) {
                $users->leftJoin('user_interest', 'user_interest.user_id', '=',
                        'users.id');
                // надо плдучить массив id штеукуыщцж
                $interest_array = array();
                foreach ($interest as $item) {
                    array_push($interest_array, $item->id);
                }

                $users->whereIn('user_interest.interest_id', $interest_array);
            }

            $targets = $seachSettings->target()->get();

            if ($targets->isNotEmpty()) {

                $users->leftJoin('user_target', 'user_target.user_id', '=',
                        'users.id');
                // надо плдучить массив id штеукуыщцж
                $interest_array = array();
                foreach ($targets as $item) {
                    array_push($interest_array, $item->id);
                }
                $users->whereIn('user_target.target_id', $interest_array);
            }


            if ($seachSettings->children != null || $seachSettings->children != 0) {
                $users->where('children_id', '=', $seachSettings->children);
            }


            $city = City::getCurrentCity();

            if ($city != null) {
                $users->where('city_id', $city->id);
            }

            if ($seachSettings->meet != null
                    && $seachSettings->meet != "nomatter"
            ) {
                $users->where('sex', '=', $seachSettings->meet);
            }

            if (isset($seachSettings) && $seachSettings->relation != 0) {
                $users->where('relation_id', '=', $seachSettings->relation);
            }

            if (isset($seachSettings) && $seachSettings->age_from != null) {
                $users->where(DB::raw(" TIMESTAMPDIFF(YEAR, date_birth,NOW())"), ">=", $seachSettings->age_from);
            }

            if (isset($seachSettings) && $seachSettings->age_to != null) {
                $users->where(DB::raw(" TIMESTAMPDIFF(YEAR, date_birth,NOW())"), "<=", $seachSettings->age_to);
            }

            if (Auth::user() != null) {
                $users->where('id', '!=', Auth::user()->id);
            }



            $users->select('users.id', 'users.name', 'users.profile_url', 'users.date_birth',
                    'users.created_at');

            $users->orderByDesc('created_at');

            $users = $users->paginate($this->paginate);;

            return $users;

        }

    }