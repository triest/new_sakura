<?php
/**
 * Created by PhpStorm.
 * User: triest
 * Date: 05.09.2020
 * Time: 14:18
 */

namespace App\Service;


use App\Models\Children;
use App\Models\City;
use App\Models\Interest;
use App\Models\Lk\User;
use App\Models\Relation;
use App\Models\SearchSettings;
use App\Models\Target;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SearchService
{
    private $limit = 16;

    private $paginate = 12;

    public function search()
    {
        $userAuth = Auth::user();
        if ($userAuth != null) {
            if ($userAuth != null) {
                $seachSettings = $userAuth->seachsettings()->first();
            }
        } else {
            if (isset($_COOKIE["searchSettings"])) {
                $cookie = $_COOKIE["searchSettings"];
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

            $users->select(
                    'users.id',
                    'users.name',
                    'users.profile_url',
                    'users.date_birth',
                    'users.created_at',
                    'users.age',
                    'users.photo_profile_url'
            )->distinkt('users.id')->limit($this->limit);



            $num_pages = intval($count / $this->limit);
            $users->distinct()->limit($this->limit);
            $users->orderByDesc('created_at')->get();
            $users = $users->paginate($this->paginate);

            return $users;
        }


        $users = User::select(['*']);

        $interest = $seachSettings->interest()->get();


        if ($interest->isNotEmpty()) {
            $users->leftJoin(
                    'user_interest',
                    'user_interest.user_id',
                    '=',
                    'users.id'
            );
            // надо плдучить массив id штеукуыщцж
            $interest_array = array();
            foreach ($interest as $item) {
                array_push($interest_array, $item->id);
            }

            $users->whereIn('user_interest.interest_id', $interest_array);
        }

        $targets = $seachSettings->target()->get();

        if ($targets->isNotEmpty()) {
            $users->leftJoin(
                    'user_target',
                    'user_target.user_id',
                    '=',
                    'users.id'
            );
            // надо плдучить массив id штеукуыщцж
            $interest_array = array();
            foreach ($targets as $item) {
                array_push($interest_array, $item->id);
            }
            $users->whereIn('user_target.target_id', $interest_array);
        }


        if ($seachSettings->children != null && $seachSettings->children != 3) {
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
            $users->where('users.id', '!=', Auth::user()->id);
        }


        $users->select(
                'users.id',
                'users.name',
                'users.profile_url',
                'users.date_birth',
                'users.created_at',
                'users.age',
                'users.photo_profile_url'
        )->distinct();

        $users->orderByDesc('created_at');

        $users = $users->paginate($this->paginate);;

        return $users;
    }

    public function getSettings()
    {
        $targets = Target::select(['id', 'name'])->get();
        $interests = Interest::select(['id', 'name'])->get();
        $children = Children::select(['id', 'name'])->get();

        $aperance_array = array();

        $userAuth = Auth::user();
        if ($userAuth != null) {
            $user = User::select(['id', 'name'])
                    ->where('id', $userAuth->id)->first();


            $selectedTargets = $user->target(['id', 'name'])->get();
            $targets_array = array();
            foreach ($selectedTargets as $item) {
                $targets_array[] = $item->id;
            }


            $selectedInteres = $user->interest(['id', 'name'])->get();
            $interest_array = array();
            foreach ($selectedInteres as $item) {
                $interest_array[] = $item->id;
            }

            //;jcnftv j,obt yfcnhjqrb
            $sechSettings = SearchSettings::select(
                    [
                            '*',
                    ]
            )->where('user_id', $user->id)->first();
        } else {
            if (isset($_COOKIE["searchSettings"])) {
                $cookie = $_COOKIE["searchSettings"];
            } else {
                $cookie = null;
            }

            if ($cookie != null) {
                $sechSettings = SearchSettings::select(
                        [
                                '*',
                        ]
                )
                        ->where('cookie', $cookie)->first();
            }
        }

        //��� �������� ������������� ���������.
        if (isset($sechSettings) && $sechSettings != null) {
            $interest_array_temp = $sechSettings->interest()->get();

            $interest_array = array();
            foreach ($interest_array_temp as $item) {
                $interest_array[] = $item->id;
            }


            $targets_array_temp = $sechSettings->target()->get();

            $targets_array = array();
            foreach ($targets_array_temp as $item) {
                $targets_array[] = $item->id;
            }
        }


        if (!isset($user)) {
            $user = null;
        }
        if (!isset($targets_array)) {
            $targets_array = array();
        }
        if (!isset($interest_array)) {
            $interest_array = array();
        }
        if (!isset($sechSettings)) {
            $sechSettings = array();
        }


        $seachSettingsArray = array();
        if (!empty($sechSettings)) {
            $seachSettingsArray['id'] = $sechSettings->id;
            $seachSettingsArray['meet'] = $sechSettings->meet;
            $seachSettingsArray['age_from'] = $sechSettings->age_from;
            $seachSettingsArray['age_to'] = $sechSettings->age_to;
            $seachSettingsArray['children'] = $sechSettings->children;
            $seachSettingsArray['relation'] = $sechSettings->relation_id;
        }

        $relations = Relation::select(['*'])->get();
        $children = Children::select(['*'])->get();

        $rez_array = [
                "anket" => $user,
                "targets" => $targets,
                "selectedTargets" => $targets_array,
                "interests" => $interests,
                "selectedInterest" => $interest_array,
                "apperance" => null,
                "relations" => $relations,
                "children" => $children,
                "sechSettings" => $seachSettingsArray,
                "smoking" => null
        ];

        return $rez_array;
    }

}
