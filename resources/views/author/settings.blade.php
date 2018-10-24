@extends('layouts.backend.app')

@section('title', 'Author Settings')

@push('css')

@endpush

@section('contents')

     <div class="container-fluid">

         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

             <div class="card">
                 <div class="header">
                     <h2>
                       Profile &  Settings
                     </h2>

                 </div>

                 <div class="body">

                     <!-- Nav tabs -->
                     <ul class="nav nav-tabs" role="tablist">

                         <li role="presentation">
                             <a href="#profile_with_icon_title" data-toggle="tab">
                                 <i class="material-icons">face</i> YOUR PROFILE
                             </a>
                         </li>

                         <li role="presentation">
                             <a href="#change_password_with_icon_title" data-toggle="tab">
                                 <i class="material-icons">lock</i>CHANGE PASSWORD
                             </a>
                         </li>


                     </ul>

                     <!-- Tab panes -->
                     <div class="tab-content">


                         <div role="tabpanel" class="tab-pane fade in active" id="profile_with_icon_title">


                             <form action="{{route('author.profile.update')}}" method="post" enctype="multipart/form-data" class="form-horizontal">

                                 @csrf
                                 @method('PUT')

                                 <div class="row clearfix">
                                     <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                         <label for="name">Name</label>
                                     </div>

                                     <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                         <div class="form-group">
                                             <div class="form-line">
                                                 <input type="text" value="{{Auth::user()->name}}" id="name" name="name" class="form-control" placeholder="Enter your  name">
                                             </div>
                                         </div>
                                     </div>
                                 </div>

                                 <div class="row clearfix">
                                     <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                         <label for="username">Username</label>
                                     </div>

                                     <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                         <div class="form-group">
                                             <div class="form-line">
                                                 <input type="text" value="{{Auth::user()->username}}" id="username" name="username" disabled class="form-control" placeholder="Enter your user name">
                                             </div>
                                         </div>
                                     </div>
                                 </div>




                                 <div class="row clearfix">
                                     <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                         <label for="email">Email </label>
                                     </div>
                                     <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                         <div class="form-group">
                                             <div class="form-line">
                                                 <input type="email"  id="email" value="{{Auth::user()->email }}" name="email" class="form-control" placeholder="Enter your email address">
                                             </div>
                                         </div>
                                     </div>
                                 </div>




                                 <div class="row clearfix">
                                     <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                         <label for="about">About me </label>
                                     </div>

                                     <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                         <div class="form-group">
                                             <div class="form-line">
                                                 <textarea name="about"  id="about" class="form-control" placeholder="write something about me" cols="5" rows="4">
                                                     {{Auth::user()->about }}
                                                 </textarea>
                                            </div>
                                         </div>
                                     </div>
                                 </div>




                                 <div class="row clearfix">
                                     <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                         <label for="about">Profile</label>
                                     </div>

                                     <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                         <div class="form-group">
                                             <div class="form-line">
                                                 <input type="file" name="image" class="form-control">
                                             </div>
                                         </div>
                                     </div>
                                 </div>








                                 <div class="row clearfix">
                                     <div class="col-lg-offset-2 col-md-offset-2 col-sm-offset-4 col-xs-offset-5">
                                         <button type="submit"class="btn btn-primary m-t-15 waves-effect">  Update profile</button>
                                     </div>
                                 </div>
                             </form>


                         </div>

                         <div role="tabpanel" class="tab-pane fade" id="change_password_with_icon_title">

                             <form action="{{route('author.password.update')}}" method="post"  class="form-horizontal">

                                 @csrf
                                 @method('PUT')

                                 <div class="row clearfix">
                                     <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                         <label for="old">Old Password</label>
                                     </div>

                                     <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                         <div class="form-group">
                                             <div class="form-line">
                                                 <input type="password" id="old" name="old_password" class="form-control" placeholder="Enter your old password">
                                                 <span class="text-danger"> {{ $errors->first('old_password') }} </span>
                                             </div>
                                         </div>
                                     </div>
                                 </div>


                                 <div class="row clearfix">
                                     <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                         <label for="new">New Password</label>
                                     </div>

                                     <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                         <div class="form-group">
                                             <div class="form-line">
                                                 <input type="password" id="new" name="password" class="form-control" placeholder="Enter your new password">
                                                 <span class="text-danger"> {{ $errors->first('password') }} </span>
                                             </div>
                                         </div>
                                     </div>
                                 </div>


                                 <div class="row clearfix">
                                     <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                         <label for="confirm_new">Confirm Password</label>
                                     </div>

                                     <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                         <div class="form-group">
                                             <div class="form-line">
                                                 <input type="password" id="confirm_new" name="password_confirmation" class="form-control" placeholder="RE-enter your new password">
                                                 <span class="text-danger"> {{ $errors->first('password_confirmation') }} </span>
                                             </div>
                                         </div>
                                     </div>
                                 </div>







                                 <div class="row clearfix">
                                     <div class="col-lg-offset-2 col-md-offset-2 col-sm-offset-4 col-xs-offset-5">
                                         <button type="submit"class="btn btn-primary m-t-15 waves-effect">  Change password</button>
                                     </div>
                                 </div>
                             </form>
                         </div>



                     </div>







                 </div> {{--card body--}}

             </div>        {{--card ewnded--}}


         </div>


     </div>
@endsection




@push('js')

@endpush