<?php

    namespace App\Http\Controllers;


    use App\Http\Resources\anketList;
    use App\Http\Resources\seachSettingResource;
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

    class SearchController extends Controller
    {


        //
        public function search(Request $request, SearchService $searchService)
        {
            $users = $searchService->search();

            return anketList::collection($users);
        }


        public function getSettings(SearchService $searchService)
        {
            $settings = $searchService->getSettings();

            return new seachSettingResource($settings);
        }

        public function saveSettings(Request $request)
        {
            $seachSettings = SearchSettings::getSearchSettings();


            if (!$seachSettings) {
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
                $seachSettings->relation_id = $request->relation;
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
