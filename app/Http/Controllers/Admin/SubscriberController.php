<?php

namespace App\Http\Controllers\Admin;

use App\Subscriber;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubscriberController extends Controller
{

    public function index()
    {
        $subscribers = Subscriber::latest()->get();
        return view('admin.subscribers.subscribers', compact('subscribers'));
    }

    public  function delete($id){
       $subscription = Subscriber::findOrFail($id)->delete();
       return redirect()->back();
    }


}
