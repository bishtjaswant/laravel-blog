@extends('layouts.frontend.app')


@section('title')
   {{$post->title}}
  @endsection

@push('css')

    <link href="{{ asset('assets/frontend/single/styles.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/frontend/single/responsive.css') }}" rel="stylesheet">

    <style>
        .header-bg {
            width: 100%;
            height: 400px;
            background-image: url({{Storage::disk('public')->url('/posts/'.$post->image )}});
            background-size: cover;
        }

        .like{
            color: red;
        }
        .blue {
            color: blue;
        }
    </style>
@endpush




@section('contents')

    <div class="header-bg">

    </div><!-- slider -->

    <section class="post-area section">
        <div class="container">

            <div class="row">

                <div class="col-lg-8 col-md-12 no-right-padding">

                    <div class="main-post">

                        <div class="blog-post-inner">

                            <div class="post-info">

                                <div class="left-area">
                                    <a class="avatar" href="#"><img src="{{Storage::disk('public')->url('/profile/'.$post->user->image )}}" alt="Profile Image"></a>
                                </div>

                                <div class="middle-area">
                                    <a class="name" href="#"><b>{{ $post->user->name}} </b></a>
                                    <h6 class="date">on {{ $post->created_at }} </h6>
                                </div>

                            </div><!-- post-info -->

                            <h3 class="title"><a href="#"><b> {{ $post->title }} </b></a></h3>

                            <p class="para"> {!!  $post->body  !!}  </p>

                            <div class="post-image"><img src="{{Storage::disk('public')->url('/posts/'.$post->image )}}" alt="Blog Image"></div>


                            <ul class="tags">
                                @foreach($post->tags AS $tags )
                                    <li><a href="#">{{$tags->name}}</a></li>
                                @endforeach

                            </ul>
                        </div><!-- blog-post-inner -->




                    </div><!-- main-post -->
                </div><!-- col-lg-8 col-md-12 -->

                <div class="col-lg-4 col-md-12 no-left-padding">

                    <div class="single-post info-area">

                        <div class="sidebar-area about-area">
                            <h4 class="title"><b>ABOUT AUTHOR</b></h4>
                            <strong> {{ $post->user->name }} </strong>
                            <hr>
                            <p>
                                {{ $post->user->about }}
                            </p>
                        </div>




                        <div class="tag-area">

                            <h4 class="title"><b>Categories </b></h4>
                            <ul>

                                @foreach($post->categories AS $categories)
                                    <li><a href="#">{{   $categories->name }} </a></li>
                                @endforeach
                            </ul>

                        </div><!--tag ares -->

                    </div><!-- info-area -->

                </div><!-- col-lg-4 col-md-12 -->

            </div><!-- row -->

        </div><!-- container -->
    </section><!-- post-area -->


    <section class="recomended-area section">
        <div class="container">
            <div class="row">

                @foreach($randomposts as $randompost)

                <div class="col-lg-4 col-md-6">
                    <div class="card h-100">
                        <div class="single-post post-style-1">

                            <div class="blog-image"><img src="{{Storage::disk('public')->url('/posts/'.$randompost->image )}}" alt="Blog Image"></div>

                            <a class="avatar" href="#"><img src="{{Storage::disk('public')->url('/profile/'.$randompost->user->image )}}" alt="Profile Image"></a>

                            <div class="blog-info">

                                <h4 class="title"><a href="{{route('post.detail', $randompost->slug)}}"><b> {{$randompost->title}} </b></a></h4>

                                <ul class="post-footer">

                                    <li>
                                      @guest
                                       <a href="javascript:void(0)" onclick="toastr.info('sorry you can not like this as a guest . you need login first', 'Info')">
                                           <i class="ion-heart"></i>{{ $randompost->favouriteToUser()->count() }}</a></li>

                                    @else
                                        <a  href="javascript:void(0)" onclick="
                                                event.preventDefault();
                                                document.getElementById('addFavourite-{{$randompost->id}}').submit();
                                                "
                                            class="{{ Auth::user()->favouritePost->where('pivot.post_id',$randompost->id)->count() == 0 ? 'like' : 'blue' }}"
                                        ><i class="ion-heart"></i>{{ $randompost->favouriteToUser()->count() }}</a>

                                        <form action="{{route('favourite.post', $randompost->id )}}" method="post" style="display: none;" id="addFavourite-{{$randompost->id}}">
                                            @csrf
                                        </form>
                                           @endguest

                                    </li>

                                    <li><a href="#"><i class="ion-chatbubble"></i>6</a></li>

                                    <li><a href="#"><i class="ion-eye"></i>{{    $randompost->views }}</a></li>


                                </ul>

                            </div><!-- blog-info -->
                        </div><!-- single-post -->
                    </div><!-- card -->
                </div><!-- col-md-6 col-sm-12 -->
                    @endforeach

            </div><!-- row -->

        </div><!-- container -->
    </section>

    <section class="comment-section">
        <div class="container">
            <h4><b>POST COMMENT</b></h4>
            <div class="row">

                <div class="col-lg-8 col-md-12">
                    <div class="comment-form">
                        <form method="post">
                            <div class="row">

                                <div class="col-sm-6">
                                    <input type="text" aria-required="true" name="contact-form-name" class="form-control"
                                           placeholder="Enter your name" aria-invalid="true" required >
                                </div><!-- col-sm-6 -->
                                <div class="col-sm-6">
                                    <input type="email" aria-required="true" name="contact-form-email" class="form-control"
                                           placeholder="Enter your email" aria-invalid="true" required>
                                </div><!-- col-sm-6 -->

                                <div class="col-sm-12">
									<textarea name="contact-form-message" rows="2" class="text-area-messge form-control"
                                              placeholder="Enter your comment" aria-required="true" aria-invalid="false"></textarea >
                                </div><!-- col-sm-12 -->
                                <div class="col-sm-12">
                                    <button class="submit-btn" type="submit" id="form-submit"><b>POST COMMENT</b></button>
                                </div><!-- col-sm-12 -->

                            </div><!-- row -->
                        </form>
                    </div><!-- comment-form -->

                    <h4><b>COMMENTS(12)</b></h4>

                    <div class="commnets-area">

                        <div class="comment">

                            <div class="post-info">

                                <div class="left-area">
                                    <a class="avatar" href="#"><img src="images/avatar-1-120x120.jpg" alt="Profile Image"></a>
                                </div>

                                <div class="middle-area">
                                    <a class="name" href="#"><b>Katy Liu</b></a>
                                    <h6 class="date">on Sep 29, 2017 at 9:48 am</h6>
                                </div>

                                <div class="right-area">
                                    <h5 class="reply-btn" ><a href="#"><b>REPLY</b></a></h5>
                                </div>

                            </div><!-- post-info -->

                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt
                                ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur
                                Ut enim ad minim veniam</p>

                        </div>

                        <div class="comment">
                            <h5 class="reply-for">Reply for <a href="#"><b>Katy Lui</b></a></h5>

                            <div class="post-info">

                                <div class="left-area">
                                    <a class="avatar" href="#"><img src="images/avatar-1-120x120.jpg" alt="Profile Image"></a>
                                </div>

                                <div class="middle-area">
                                    <a class="name" href="#"><b>Katy Liu</b></a>
                                    <h6 class="date">on Sep 29, 2017 at 9:48 am</h6>
                                </div>

                                <div class="right-area">
                                    <h5 class="reply-btn" ><a href="#"><b>REPLY</b></a></h5>
                                </div>

                            </div><!-- post-info -->

                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt
                                ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur
                                Ut enim ad minim veniam</p>

                        </div>

                    </div><!-- commnets-area -->

                    <div class="commnets-area ">

                        <div class="comment">

                            <div class="post-info">

                                <div class="left-area">
                                    <a class="avatar" href="#"><img src="images/avatar-1-120x120.jpg" alt="Profile Image"></a>
                                </div>

                                <div class="middle-area">
                                    <a class="name" href="#"><b>Katy Liu</b></a>
                                    <h6 class="date">on Sep 29, 2017 at 9:48 am</h6>
                                </div>

                                <div class="right-area">
                                    <h5 class="reply-btn" ><a href="#"><b>REPLY</b></a></h5>
                                </div>

                            </div><!-- post-info -->

                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt
                                ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur
                                Ut enim ad minim veniam</p>

                        </div>

                    </div><!-- commnets-area -->

                    <a class="more-comment-btn" href="#"><b>VIEW MORE COMMENTS</a>

                </div><!-- col-lg-8 col-md-12 -->

            </div><!-- row -->

        </div><!-- container -->
    </section>


@endsection




@push('js')

@endpush