<?php

    namespace App\Http\Controllers;


    use App\Http\Resources\anketList;
    use App\Models\City;
    use App\Models\Interest;
    use App\Models\SearchSettings;
    use App\Models\Target;
    use App\Models\lk\User;
    use App\Service\SearchService;
    use Carbon\Carbon;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Cookie;

    class SeachController extends Controller
    {


        //
        public function seach(Request $request, SearchService $searchService)
        {
            $users = $searchService->search();



            return anketList::collection($users);
        }


        public function getSettings(Request $request)
        {


            /*
             * ������ ��� �������� ����
             * */


            $targets = Target::select(['id', 'name'])->get();
            $interests = Interest::select(['id', 'name'])->get();
            $aperance_array = array();
            //   $apperance = Aperance::select(['id', 'name'])->get();
            //   $relations = Relationh::select(['id', 'name'])->get();
            //   $chidren = Children::select(['id', 'name'])->get();
            //    $smoking = Smoking::select(['id', 'name'])->get();
            /*
                        foreach ($apperance as $item) {
                            $aperance_array[] = $item->id;
                        }
            */

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
                $sechSettings = SearchSettings::select([
                        '*',
                ])->where('user_id', $user->id)->first();
            } else {
                if (isset($_COOKIE["seachSettings"])) {
                    $cookie = $_COOKIE["seachSettings"];
                } else {
                    $cookie = null;
                }

                if ($cookie != null) {
                    $sechSettings = SearchSettings::select([
                            '*',
                    ])
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
            }

            return \response()->json([
                    "anket" => $user,
                    "targets" => $targets,
                    "selectedTargets" => $targets_array,
                    "interests" => $interests,
                    "selectedInterest" => $interest_array,
                    "apperance" => null,
                    "relations" => null,
                    "chidren" => null,
                    "sechSettings" => $seachSettingsArray,
                    "smoking" => null,

            ]);

        }

        public function saveSettings(Request $request)
        {
            $seachSettings = SearchSettings::getSeachSettings();


            if ($seachSettings == null) {
                return null;
            }

            if (isset($request->children)) {
                $seachSettings->children = $request->children;
            }

            if (isset($request->from)) {
                $seachSettings->age_from = $request->from;
            }

            if (isset($request->to)) {
                $seachSettings->age_to = $request->to;
            }

            if (isset($request->meet)) {
                $seachSettings->meet = $request->meet;
            }

            if (isset($request->relation) && !empty($request->relation)) {
                $seachSettings->relation = $request->relation;
            }

            $seachSettings->save();

            $seachSettings->target()->detach();
            $selectedTargets = $request->targets;
            foreach ($selectedTargets as $item) {
                $target = Target::select(['id', 'name'])->where('id', $item)
                        ->first();
                if ($target != null) {
                    $seachSettings->target()->save($target);
                }
            }
            $seachSettings->interest()->detach();
            $selectedTargets = $request->interests;
            foreach ($selectedTargets as $item) {
                $target = Interest::select(['id', 'name'])->where('id', $item)
                        ->first();
                if ($target != null) {
                    $seachSettings->interest()->save($target);
                }
            }

            return response()->json(['ok']);
        }

        public function changeFilter(Request $request)
        {
            $userAuth = Auth::user();
            if ($userAuth == null) {
                return false;
            }
            $user = User::select(['id', 'name'])
                    ->where('id', $userAuth->id)->first();
            if ($user == null) {
                return false;
            }


            if ($user->filter_enable == 0) {
                User::where('id', $user->id)
                        ->update(['filter_enable' => 1]);

                DB::table('users')->where('user_id', $user->id)
                        ->update(['filter_enable' => 1]);
            } else {
                DB::table('users')->where('user_id', $user->id)
                        ->update(['filter_enable' => 0]);
            }


            return response()->json(['ok']);
        }
    }
