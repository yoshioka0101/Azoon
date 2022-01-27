<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use \App\Memo;
use \App\User;
use Illuminate\Support\Facades\DB;



class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function content($id){
        $user = \Auth::user();
        $memo = Memo::where('status','1')->where('id',$id)->first();

        $memos = Memo::where('user_id',$user['id'])->where('status',1)->get();

        return view ('content',compact('memo','user','memos'));
    }

    public function search(Request $request){
        $keyword = $request->input('keyword');

        $query = Memo::query();

        if(!empty($keyword)){
            $query->where('title', 'LIKE', "%{$keyword}%");
        }

        $memo = $query ->where('status',1)->get();
        return view('search',compact('keyword','memo'));

    }

}