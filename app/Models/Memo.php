<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User; 

class Memo extends Model
{
    /*
    public function admins(){
        return $this->belongsTo('App\Admin');
    }
    */

    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'url',
        'image',
        'user_id',
        'status'
    ];

    /*public function user() {
        return $this->belongsTo('App\Models\User');
    }*/
 
    public function users()
    {
        return $this->belongsToMany('App\User')->withTimestamps();
    }
    
    public function user() {
        return $this->belongsTo('App\Models\User');
    }
 
}