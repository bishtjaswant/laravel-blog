@extends('layouts.backend.app')


@section('title', 'Posts')


@push('css')
    <!-- JQuery DataTable Css -->
    <link href="{{ asset('assets/backend/') }}plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">

@endpush




@section('contents')
    <!-- Vertical Layout -->

    <a href="{{route('admin.post.index')}}" class="btn btn-sm btn-primary" style="margin-bottom: 9px;" title="back to post page">Back</a>
    <a href="{{route('admin.post.edit', $post->id )}}" class="btn btn-sm btn-info" style="margin-bottom: 9px;" title="want to edit  this post">Edit </a>


    @if($post->is_approved ==false)
     <button type="button" style="margin-bottom: 9px;"  onclick="approvalPost()" title="{{$post->user->name}} your post is waiting for approving " class="btn  btn-sm btn-danger">
        <span class="glyphicon glyphicon-warning-sign" > </span> not approve
     </button>
     <form action="{{ route('admin.post.approve', $post->id)  }}" method="post" style="display: none;" id="aproval-post">
         @csrf
         @method('PUT')
     </form>
    @else
        <button type="button" style="margin-bottom: 9px;" title="{{$post->user->name}} your post is already approved "  class="btn disabled  btn-sm btn-success">
            <span class="material-icons">done</span> Approved
        </button>
    @endif

    <div class="row clearfix">


        {{--title--}}
        <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">

            <div class="card">
                <div class="header">

                    <h2 class="text-capitalize text-left">    {{ $post->title }} </h2>

                    <small class="text-dark text-capitalize"> Posted by {{ $post->user->name }} on {{ $post->created_at->toFormattedDateString() }} </small>


                </div>
                <div class="body">
                    <h2 class="text-capitalize text-left">    Title descripton </h2>
                    {!!   $post->body !!}

                </div>
            </div>

            <div class="card">

                <div class="body">

                    <div class="card bg-orange">
                        <div class="header">

                            <h2 class="text-capitalize text-left"> Your  post image </h2>

                        </div>
                        <div class="body">


                            <img src="{{ Storage::disk('public')->url('posts/'.$post->image ) }}" alt="upload-image" class="img-thumbnail img-responsive">

                        </div>
                    </div>

                </div>
            </div>

        </div>


        {{--tags and category--}}
        <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">


            {{--views--}}
            <div class="card bg-lime">
                <div class="header">

                    <h2 class="text-capitalize text-left"> Author's Username </h2>

                </div>
                <div class="body">


                    <p> {{ $post->user->username }}</p>
                </div>
            </div>


            {{--views--}}
            <div class="card bg-deep-purple">
                <div class="header">

                    <h2 class="text-capitalize text-left"> post slug </h2>

                </div>
                <div class="body">

                    <p class="text-dark" style="font-size: 25px;text-align: center;"> {{ $post->slug}}  </p>


                </div>
            </div>


            <div class="card bg-pink">
                <div class="header">

                    <h2 class="text-capitalize text-left"> Categories </h2>

                </div>
                <div class="body">

                    @foreach($post->categories AS $postCategory )
                        <span class="label bg-cyan">   {{$postCategory->name }}</span>
                    @endforeach


                </div>
            </div>

            {{----}}
            <div class="card bg-amber">
                <div class="header">
                    <h2 class="text-capitalize text-left">  Tags </h2>
                </div>
                <div class="body">


                    @foreach($post->tags AS $postTags )
                        <span class="label bg-cyan">   {{$postTags->name }}</span>
                    @endforeach


                </div>
            </div>


            {{--views--}}
            <div class="card bg-light-blue">
                <div class="header">

                    <h2 class="text-capitalize text-left"> Views </h2>

                </div>
                <div class="body">

                    <p class="text-dark" style="font-size: 25px;text-align: center;"> {{ $post->count() }} &nbsp;&nbsp; <i class="material-icons">visibility</i>  </p>


                </div>
            </div>

            {{----}}
        </div>








    </div>
    <!-- #END# Vertical Layout -->




@endsection



@push('js')

@endpush



<script src="https://unpkg.com/sweetalert2@7.19.1/dist/sweetalert2.all.js"></script>

<script>
    function approvalPost() {


        const swalWithBootstrapButtons = swal.mixin({
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false,
        })

        swalWithBootstrapButtons({
            title: 'Are you sure want to approve this post?',
            // text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, approve it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                event.preventDefault();
                document.getElementById('aproval-post').submit();
                // swalWithBootstrapButtons(
                //     'Approved !',
                //     'Your have approved this  post.',
                //     'success'
                // )
            } else if (
                // Read more about handling dismissals
                result.dismiss === swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons(
                    'Cancelled',
                    'this post still waiting for approve :)',
                    'info'
                )
            }
        })

    }
</script>
