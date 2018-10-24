@extends('layouts.frontend.app')


@section('title', 'blog')

@push('css')

    <link href="{{ asset('assets/frontend/css/home/styles.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/frontend/css/home/responsive.css') }}" rel="stylesheet">
    <style>
             .like { color: red;} .blue { color: blue;}
    </style>

@endpush


@section('contents')

    {{--{{print_r($categories)}}--}}

    <div class="main-slider">
        <div class="swiper-container position-static" data-slide-effect="slide" data-autoheight="false"
             data-swiper-speed="500" data-swiper-autoplay="10000" data-swiper-margin="0" data-swiper-slides-per-view="4"
             data-swiper-breakpoints="true" data-swiper-loop="true" >
            <div class="swiper-wrapper">

                @foreach($categories as $category)
                    <div class="swiper-slide">

                        <a class="slider-category" href="#">
                            <div class="blog-image"><img src="{{Storage::disk('public')->url('category/slider/'. $category->image ) }}" alt="{{$category->name}}"></div>

                            <div class="category">
                                <div class="display-table center-text">
                                    <div class="display-table-cell">
                                        <h3><b>{{ $category->name }}</b></h3>
                                    </div>
                                </div>
                            </div>

                        </a>
                    </div><!-- swiper-slide -->

                @endforeach
            </div><!-- swiper-wrapper -->

        </div><!-- swiper-container -->

    </div><!-- slider -->

    <section class="blog-area section">
        <div class="container">

            <div class="row">

                @foreach($posts as  $post)
                    <div class="col-lg-4 col-md-6">
                        <div class="card h-100">
                            <div class="single-post post-style-1">

                                <div class="blog-image"><img src="{{Storage::disk('public')->url('/posts/'. $post->image ) }}" alt="{{ $post->image }}"></div>

                                <a class="avatar" href="#"><img src="{{Storage::disk('public')->url(  '/profile/'.$post->user->image )  }}" alt="Profile Image"></a>

                                <div class="blog-info">

                                    <h4 class="title"><a href="{{route('post.detail',$post->slug )}}"><b>{{ $post->title }}</b></a></h4>

                                    <ul class="post-footer">

                                        <li>

                                            @guest
                                                <a href="javascript:void(0)" onclick="toastr.info('sorry you can not like this as a guest . you need login first', 'Info')"><i class="ion-heart"></i>{{ $post->favouriteToUser()->count() }}</a></li>

                                           @else
                                            <a  href="javascript:void(0)" onclick="
                                            event.preventDefault();
                                            document.getElementById('addFavourite-{{$post->id}}').submit();
                                           "
                                            class="{{ Auth::user()->favouritePost->where('pivot.post_id',$post->id)->count() == 0 ? 'like' : 'blue' }}"
                                            ><i class="ion-heart"></i>{{ $post->favouriteToUser()->count() }}</a>

                                            <form action="{{route('favourite.post', $post->id )}}" method="post" style="display: none;" id="addFavourite-{{$post->id}}">
                                                @csrf
                                            </form>

                                         </li>

                                        @endguest

                                        <li><a href="#"><i class="ion-chatbubble"></i>6</a></li>


                                        <li><a href="#"><i class="ion-eye"></i>{{$post->views}}</a></li>


                                    </ul>

                                </div><!-- blog-info -->
                            </div><!-- single-post -->
                        </div><!-- card -->
                    </div><!-- col-lg-4 col-md-6 -->


                @endforeach
            </div><!-- row -->

            <a class="load-more-btn" href="#"><b>LOAD MORE</b></a>

        </div><!-- container -->
    </section><!-- section -->



@endsection




@push('js')

@endpush