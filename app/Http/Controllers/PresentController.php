<?php

    namespace App\Http\Controllers;

    use App\Http\Requests\GetAnketPresents;
    use App\Http\Requests\MakePresentRequwest;
    use App\Models\GiftAct;
    use App\Models\Lk\User;
    use App\Models\Present;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Symfony\Component\Console\Input\Input;

    class PresentController extends Controller
    {
        //
        public function list(Request $request)
        {
            $presents = Present::getPresents();
            return response()->json(["presents" => $presents]);
        }

        public function make(MakePresentRequwest $request)
        {
            $user = User::get(intval($request->user_id));

            if (!$user) {
                return response()->json(["result"=>false]);
            }

            if ($user->makeGift($request->present_id)) {
                return response()->json(["result"=>true]);
            } else {
                return response()->json(["result"=>false]);
            }
        }

        public function getAnketPresents(GetAnketPresents $request)
        {
            if (!isset($request->user_id)) {
                return null;
            }

            $user = User::get(intval($request->get("user_id")));
            if (!$user) {
                return response()->json(false);
            }
            $gifs = $user->getGifts(30);
            return response()->json(["gifs" => $gifs]);
        }
    }
