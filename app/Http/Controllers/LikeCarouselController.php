<?php

    namespace App\Http\Controllers;

    use App\Models\City;
    use App\Models\Lk\User;
    use App\Service\LikeCarouselService;
    use http\Env\Response;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\DB;

    class LikeCarouselController extends Controller
    {
        //
        public function index(Request $request)
        {
            return view("like-carousel.index");
        }

        public function getAnket()
        {
            $userAuth = Auth::user();

            $likeCarouselService = new LikeCarouselService();
            $anket = $likeCarouselService->getAnket($userAuth);

            if ($anket) {
                $online = $anket->isOnline();
                $last_login = $anket->lastLoginFormat();
            }else{
                $online=false;
                $last_login=null;
            }
            return response()->json(
                    [
                            'ankets' => $anket,
                            'online' => $online,
                            'last_login' => $last_login,
                    ]
            );
        }

        public function newLike(Request $request)
        {

            if($request->action=="like" && !Auth::user()){
                return  response('',401);
            }

            $user = User::find($request->user_id);

            if (!$user) {
                return response()->json(['result'=>false]);
            }
            $result=$user->newLike();


            return response()->json($result);
        }

        public function checkLike(Request $request)
        {

            $user = User::get($request->user_id);

            $authUser=Auth::user();


            if ($user == null || $authUser==null) {
                return response()->json(['result'=>false]);
            }
            $result=$user->checkLike($authUser);

            return response()->json(['result'=>$result]);
        }


        protected function _error($code, $message, $msgShouldBeShow = false)
        {
            return response()->json([
                                            'success' => false,
                                            'message' => $message,
                                            'msgShouldBeShown' => $msgShouldBeShow
                                    ], $code);
        }
    }
