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
        $memos = Memo::count();
        $user = \DB::table('follow_users')->
                join('users','users.id','=','followed_user_id')->
                count();

        //dd($user);    
        return view('userlist',compact('userlist','memos','user'));        
        }            

}
