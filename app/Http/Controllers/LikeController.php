<?php

namespace App\Http\Controllers;

use App\Models\Lk\User;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    //
    public function newLike(Request $request)
    {
        $target = User::where('id', $request->user_id)->first();

        $target->newLike();


//        $target->sendMesage("Вы кому-то понравились");

        return response()->json(['ok']);
    }
}
