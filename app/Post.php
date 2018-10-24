<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{


    public  function user() {
        return $this->belongsTo('App\User'); // post does belongsto a perticulllay user
    }


    public  function categories() {
        return $this->belongsToMany('App\Category')->withTimestamps(); // a post belongsto many categories
    }


    public  function tags() {
        return $this->belongsToMany('App\Tag')->withTimestamps() ; // a post  belongstomany tags

    }


    public  function favouriteToUser() {
        return $this->belongsToMany('App\User')->withTimestamps();
    }








}
