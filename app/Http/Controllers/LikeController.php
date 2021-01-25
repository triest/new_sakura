<?php

namespace App\Http\Controllers;

use App\Models\Lk\User;
use App\Service\LikeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    //
    public function newLike(Request $request)
    {
        $target = User::where('id', $request->user_id)->first();

        if (!$target) {
            return response()->json(false);
        }

        $target->newLike();


        return response()->json(['ok']);
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect('/login');
        }

        $likeService = new LikeService();
        $likes = $likeService->getMyLikes();
        return view('like.index')->with(['likes' => $likes]);
    }
}
