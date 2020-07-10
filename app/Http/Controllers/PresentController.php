<?php

    namespace App\Http\Controllers;

    use App\GiftAct;
    use App\Models\Lk\User;
    use App\Present;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;

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
    }
