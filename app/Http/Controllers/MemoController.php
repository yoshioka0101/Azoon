<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use \App\Memo;
use \App\User;




class MemoController extends Controller
{
    public function timeline() {
        $memos = Memo::query()->whereIn('user_id', Auth::user()->follows()->pluck('followed_user_id'))->latest()->paginate();

        return view('home')->with(['memos' => $memos]);
    }
}
