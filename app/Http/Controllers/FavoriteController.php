<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Memo;
use App\User;
use Illuminate\Support\Facades\DB;
use Auth;

class FavoriteController extends Controller
{

    public function store($id)
    {
        $memo = Memo::find($id);
        $memo->users()->attach(Auth::id());
        
        return redirect()->route('home');
    }


    public function destroy($id)
    {
        $memo = Memo::find($id);
        $memo->users()->detach(Auth::id());

        return redirect()->route('home');
    }

    public function userlist(){
        $userlist = User::paginate(10);
        $memos = DB::table('memo_user')->
                join('users' , 'users.id' , '='  ,'memo_user.user_id')->
                count();
        //dd($memos);    
        return view('userlist',compact('userlist','memos'));        
        }            



}
