<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    function posts(){
        return $this->belongsToMany('App\Post')->withTimestamps();
    }
}
