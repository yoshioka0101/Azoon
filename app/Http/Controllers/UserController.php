<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(): View
    {
        $users = User::query()
            ->withCount(['memosCheckedTrue', 'memosCheckedFalse'])
            ->get();
        return view('userlist', compact('users'));
    }
}
