<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Memo extends Model
{
    /*
    public function admins(){
        return $this->belongsTo('App\Admin');
    }
    */

    protected $fillable = [
        'title',
        'contnet',
        'url',
        'image'
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

