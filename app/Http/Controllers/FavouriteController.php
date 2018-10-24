<?php

namespace App\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavouriteController extends Controller
{
   function add(  $post){
        $user = Auth::user();

        $isFavourite = $user->favouritePost()->where('post_id', $post)->count();


        if ($isFavourite == 0) {
            $user->favouritePost()->attach($post);
            Toastr::success('Liked', 'Success');
            return redirect()->back();
        } else {
            $user->favouritePost()->detach($post);
            Toastr::error('Disliked', 'Error');
            return redirect()->back();
        }






   }




}
