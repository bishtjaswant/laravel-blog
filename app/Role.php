<?php

namespace App;


use Illuminate\Database\Eloquent\Model;


class Role extends Model
{
    //
    public function users()
    {
    	// One role may  be belongs to many users
        return 	$this->hasMany('App\User');
    }








    
}
