<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Memo;
use \App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class AccountController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function newpost()
    {
        $user = \Auth::user();

        return view('newpost',compact('user'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        //dd($data);
        
        $image = $request->file('image');
        if($request->hasFile('image')){
            $path = \Storage::put('/public', $image);
            $path = explode('/', $path);
        }else{
            $path = null;
        }
        //dd($image);
        // POSTされたデータをDB（memosテーブル）に挿入
        // MEMOモデルにDBへ保存する命令を出す
        $memo_id = Memo::insertGetId(
            ['title' => $data['title'],
            'content' => $data['content'],
            'user_id' => $data['user_id'],  
            'image' => $path[1],
            'url' => $data['url'],
            'status' => 1
            ]);

        // リダイレクト処理
        return redirect()->route('home');
    }

    public function edit($id){
        $user = \Auth::user();
        $memo = Memo::where('status','1')->where('id',$id)->first();
        $memos = Memo::where('status',1)->get();
        
        return view ('edit',compact('memo','user','memos'))->with('flash_edit', '投稿が完了しました');
        
    }

    public function update(Request $request , $id ){
        $inputs = $request->all();
        //dd($inputs);
        $data = ['title' => $inputs['title'],
                'content' => $inputs['content'],
                'url' => $inputs['url'],
                ];
        if($request->hasFile('image')) {
            $path = $request->file('image')->store('public');
            $data['image'] = basename($path);
            
        }

        Memo::where('id',$id)->update($data);

        return redirect()->route('home');
    }

    public function delete(Request $request , $id){
        $inputs = $request->all();
        //dd($inputs);
        Memo::where('id',$id)->update([ 'status' => 2 ]);
    
        return redirect()->route('home')->with('flash-delete','メモの削除が完了しました');
    }

    /*
    public function userlist(){
        $userlist = User::paginate(10);
        $memos = Memo::where('status','1')->count();
        
        return view('userlist',compact('userlist','memos'));        
        }            
    */
    
    public function userdetail($id){
        $user = User::where('id',$id)->first();
        $memos = Memo::where('status',1)->get();
        //dd($memos);
        return view('userdetail',compact('user','memos'));
    }

    public function account(Request $request,$id){
        $inputs = $request->all();
        
        User::where('id',$id)->update([ 'role' => 1 ]);

        return redirect()->route('home');
      }


      public function accountdelete(Request $request,$id){
        $inputs = $request->all();
        User::where('id',$id)->update([ 'role' => 10 ]);

        return redirect()->route('home');
      }

}
