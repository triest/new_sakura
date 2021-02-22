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

        return view('like.index');
    }

    public function getMyLikes(Request $request)
    {
        $likeService = new LikeService();
        $likes = $likeService->getMyLikes();
        if (!$likes) {
            return response()->json(['result' => false, ['data' => []]]);
        } else {
            return response()->json(['result' => true, 'data' => $likes]);
        }
    }
}
