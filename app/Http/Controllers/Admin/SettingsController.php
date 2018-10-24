<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class SettingsController extends Controller
{
    public  function index()
     {

        return view('admin.settings');
    }

    public function profileUpdate(Request $request )
    {

            $this->validate($request, [
                "name" => "required",
                "email" => "required|email",
                "about" => "required",
//                "image" => "required|image",
            ]);

//            get user
        $user = User::findOrFail(Auth::id());

            $image = $request->file('image');
            $slug = str_slug($request->name);

//            if img setStorage
          if ($image) {

              $currentDate = Carbon::now()->toDateString();
              $imagename=  $slug . '-' . $currentDate .  '-'. uniqid() . '.' . $image->getClientOriginalExtension()  ;

//              if profile dir not exist
                if (!Storage::disk('public')->exists('/profile')) {
                     Storage::disk('public')->makeDirectory('/profile');
                }

//                if user's progile already exist than delete that photo
              if (Storage::disk('public')->exists('/profile/'.$user->image)){
                  Storage::disk('public')->delete('/profile/'.$user->image);
              }

//                manipulating pic
              $newImage = Image::make($image)->resize(500,500)->save();


//              if profile dir exist
             if (Storage::disk('public')->exists('/profile')) {
                 Storage::disk('public')->put('/profile/'.$imagename, $newImage );
             }



          } else {
                $imagename = $user->image;
          }

//          now the update
        $user->name = $request->name;
        $user->email = $request->email;
        $user->image = $imagename;
        $user->about = $request->about;
        $user->save();

        Toastr::success('profile updated' , 'Success' );
        return redirect()->back();

    }


    public function  passwordUpdate(Request $request) {


        $this->validate($request, [

            'old_password' => 'required|min:5',
            'password' => 'required|confirmed|min:5'
        ]);

//        get HASH Password
        $userHashedPassword = User::findOrFail(Auth::id());


        if (Hash::check($request->old_password, $userHashedPassword->password )) {

            if (!Hash::check($request->password, $userHashedPassword->password )){
                 $userHashedPassword->password = Hash::make($request->password);
                 $userHashedPassword->save();
                Toastr::success('password changed ','Success');
                Auth::logout();
                return redirect()->back();
            } else {
                Toastr::error('the new password can not be same as old password ','Error');
                return redirect()->back();
            }

        } else {
          Toastr::error('WRONG PASSWORD','Error');
          return redirect()->back();
        }



    }









}
