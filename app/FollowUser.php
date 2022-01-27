<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

    class FollowUser extends Model
{
    protected $fillable = ['following_user_id', 'followed_user_id'];

    protected $table = 'follow_users';


}
