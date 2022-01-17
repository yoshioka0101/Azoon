<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use \App\Memo;
use \App\User;


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
    public function index()
    {
        //↓でログインしているユーザの情報を渡す
        $user = \Auth::user();
        //ここでメモの中身をログインしているアカウントのIDと一致させないといけない
        $memos = Memo::where('status',1)->orderBy('created_at','DESC')->paginate(10);
        //dd($memos);
        return view('home',compact('user','memos'));
    }


    public function content($id){
        $user = \Auth::user();
        $memo = Memo::where('status','1')->where('id',$id)->first();

        $memos = Memo::where('user_id',$user['id'])->where('status',1)->get();

        return view ('content',compact('memo','user','memos'));
    }

    public function checklist(Request $request , $id){
        $input = $request->all();
        //dd($inputs);
        Memo::where('id',$id)->update([ 'checklist' => 1 ]);
        
        return redirect()->route('home');
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