<?php

    namespace App\Http\Controllers;

    use App\Models\City;
    use App\Models\Lk\User;
    use App\Service\LikeCarouselService;
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
            $userAuth = Auth::user();

            $likeCarouselService = new LikeCarouselService();
            $anket = $likeCarouselService->getAnket($userAuth);

            $city = null;
            if ($anket->city_id != null) {
                $city = City::get($anket->city_id);
            }
            $targets = $anket->target()->get();
            $interets = $anket->interest()->get();

            $online = $anket->isOnline();
            $last_login = $anket->lastLoginFormat();

            return response()->json([
                    'ankets' => $anket,
                    'online' => $online,
                    'city' => $city,
                    'targets' => $targets,
                    'interets' => $interets,
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
