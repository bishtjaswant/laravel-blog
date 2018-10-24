<?php

namespace App\Http\Controllers;

use App\Subscriber;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{

    public  function store(Request $request)
    {
        $this->validate($request, [
            "email" => "required|email|unique:subscribers"
        ]);

        $subscribed = new Subscriber();
        $subscribed->email = $request->get('email');
        $subscribed->save();
        Toastr::success('Email Subscribed','Success');
        return redirect()->back();

    }










}

