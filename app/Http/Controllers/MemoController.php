<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Memo;
use App\Models\User;

class MemoController extends Controller
{
    public function timeline() {
        $memos = Memo::query()
            ->where('status', 1)
            ->whereIn('user_id', Auth::user()->follows()->pluck('followed_user_id'))
            ->latest()
            ->paginate();

        return view('home')->with(['memos' => $memos]);
    }

    public function createPost(Request $request)
    {
        //バリデーション
        $request->validate([
            'content' => 'required|string|max:1000',
            'video_url' => 'nullable|url',
        ]);

        //投稿を作成
        $memo = Memo::create([
            'user_id' => Auth::id(),
            'content' => $request->input('content'),
            'video_url' => $request->input('video_url'), // S3の動画URL
            'status' => 1
        ]);

        return redirect()->route('home')->with('success', '投稿を作成しました！');
    }
}