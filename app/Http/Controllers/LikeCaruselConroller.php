<?php

    namespace App\Http\Controllers;

    use App\Models\City;
    use App\Models\Lk\User;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\DB;

    class LikeCaruselConroller extends Controller
    {
        //
        public function index(Request $request)
        {


            return view("like-carusel.index");
        }

        public function getAnket()
        {
            $girls = null;
            $userAuth = Auth::user();


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

            if ($girls==null){
                return response()->json([
                        'ankets'     => null,
                        'online'     => false,
                        'city'       => null,
                        'targets'    => null,
                        'interets'   => null,
                        'last_login' => null,
                ]);
            }

            $girls = User::get($girls->id);
            $city = null;
            if ($girls->city_id != null) {
                $city = City::get($girls->city_id);
            }
            $targets = $girls->target()->get();
            $interets = $girls->interest()->get();

            $online = $girls->isOnline();
            $last_login = $girls->lastLoginFormat();

            return response()->json([
                    'ankets'     => $girls,
                    'online'     => $online,
                    'city'       => $city,
                    'targets'    => $targets,
                    'interets'   => $interets,
                    'last_login' => $last_login,
            ]);
        }

        public function newLike(Request $request)
        {
            $girl = User::get($request->user_id);
            $girl->newLike();

            return response()->json(['ok']);
        }

        public function checkLike(Request $request)
        {
            $girl = User::get($request->anket_id);

            if ($girl == null) {
                return response()->json(false);
            }

            return response()->json($girl->checkLike());
        }

    }
