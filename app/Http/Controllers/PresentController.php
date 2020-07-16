<?php

    namespace App\Http\Controllers;

    use App\GiftAct;
    use App\Models\Lk\User;
    use App\Present;
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

        public function make(Request $request)
        {
            $validatedData = $request->validate([
                    'user_id' => 'required',
                    'present_id' => 'required',
            ]);

            $user = User::get(intval($request->user_id));

            if ($user->makeGift($request->present_id)) {
                return response()->json(true);
            } else {
                return response()->json(false);
            }
        }

        public function getAnketPresents(Request $request)
        {


            if (!isset($request->user_id)) {
                return null;
            }

            $user = User::get(intval($request->get("user_id")));
            $gifs = $user->getGifts(30);
            return response()->json(["gifs" => $gifs]);
        }
    }
