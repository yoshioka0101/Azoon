<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\User;
use App\FollowUser;

class FollowUserController extends Controller
{
    public function follow(User $user) {
        $follow = FollowUser::create([
            'following_user_id' => \Auth::user()->id,
            'followed_user_id' => $user->id,
        ]);
        $followCount = count(FollowUser::where('followed_user_id', $user->id)->get());
        return redirect('home');
    }
    
    public function unfollow(User $user) {
        $follow = FollowUser::where('following_user_id', \Auth::user()->id)->where('followed_user_id', $user->id)->first();
        $follow->delete();
        $followCount = count(FollowUser::where('followed_user_id', $user->id)->get());

        return redirect('home');
    }
}