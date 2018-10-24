@extends('layouts.backend.app')

@section('title','update post')

@push('css')
    <!-- post Bootstrap Select Css -->
    <link href="{{asset('assets/backend')}}/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />


@endpush



@section('contents')
<h4>ADMIN FORM</h4>

    <form enctype="multipart/form-data" class="form-horizontal" action="{{ route('author.post.update', $post->id ) }}" method="post">

    @csrf
    @method('PUT')

    <!-- Horizontal Layout -->
        <div class="row clearfix">

            {{--new post--}}
            <div class="col-lg-8 col-md-12 col-sm-12  col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Edit Post
                        </h2>

                    </div>
                    <div class="body">


                        <div class="row clearfix">
                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                <label for="title">Post title </label>
                            </div>
                            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" name="title" id="title" class="form-control" value="{{ $post->title }}" placeholder="Type post title">


                                    </div>
                                </div>

                            </div>

                        </div>

                        {{--image--}}

                        <div class="row clearfix">
                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                <label for="image">Post image </label>
                            </div>
                            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="file" name="image" id="image" class="form-control">

                                        <img src="{{Storage::disk('public')->url('posts/'. $post->image)  }}" width="120" height="120" class="img-thumbnail img-responsive" alt="">



                                    </div>
                                </div>


                            </div>

                        </div>




                        {{--publish--}}
                        <div class="form-group">

                            &nbsp;&nbsp;&nbsp;  <input  type="checkbox" id="publish" name="status" value="1" {{ $post->status==true ? 'checked' : ''}}  class="filled-in">

                            <label for="publish"><strong>Publish</strong></label>

                        </div>





                    </div>
                </div>



            </div>



            {{--all tags categories--}}
            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Categories & Tags
                        </h2>

                    </div>


                    <div class="body" >

                        <div class="form-group form-float">
                            <div class="form-inline {{ $categories->has('errors') ? 'focused error' : '' }}">
                                <label for="category">Select a Category</label>
                                <select class="form-control show-tick" multiple data-live-search="true" name="categories[]" id="category">
                                    @foreach($categories AS $category)
                                        <option value="{{ $category->id }}"


                                        @foreach($post->categories as $postCategory)
                                            {{ $postCategory->id === $category->id ? 'selected' : '' }}
                                        @endforeach



                                        > {{ $category->name }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <br>

                        <div class="form-group form-float">
                            <div class="form-inline {{ $tags->has('errors') ? 'focused error' : '' }}">
                                <label for="category">Select a Tags</label>
                                <select class="form-control show-tick" multiple data-live-search="true" name="tags[]" id="category">
                                    @foreach($tags AS $tag)
                                        <option value="{{ $tag->id }}"

                                        @foreach( $post->tags AS $postTag )
                                            {{ $postTag->id === $tag->id ? 'selected':'' }}
                                        @endforeach

                                        > {{ $tag->name }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>



                        <a href="{{route('author.post.index')}}" class="btn btn-primary m-t-15 waves-effect">Cancel</a>
                        <button type="submit" class="btn btn-info m-t-15 waves-effect">Update</button>

                    </div>

                </div>
            </div>
        </div>




        </div>













        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Please write a descriptions about Your title
                        </h2>

                    </div>

                    <div class="body">

                        <!-- TinyMCE -->
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="card">

                                    <div class="body" >
                                  <textarea id="tinymce" name="body">

                                  {{ $post->body }}
                                  </textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- #END# TinyMCE -->

                    </div>
                </div>
            </div>
        </div>

    </form>

@endsection


@push('js')

    <!-- post Select Plugin Js -->
    <script src=" {{asset('assets/backend/')}}plugins/bootstrap-select/js/bootstrap-select.js"></script>

    <!--post TinyMCE -->
    <script src="{{asset('assets/backend')}}/plugins/tinymce/tinymce.js"></script>

    {{--custom editor js--}}
    <script>

        $(function () {

            //TinyMCE
            tinymce.init({
                selector: "textarea#tinymce",
                theme: "modern",
                height: 300,
                plugins: [
                    'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                    'searchreplace wordcount visualblocks visualchars code fullscreen',
                    'insertdatetime media nonbreaking save table contextmenu directionality',
                    'emoticons template paste textcolor colorpicker textpattern imagetools'
                ],
                toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
                toolbar2: 'print preview media | forecolor backcolor emoticons',
                image_advtab: true
            });
            tinymce.suffix = ".min";
            tinyMCE.baseURL = '{{ asset('assets/backend') }}/plugins/tinymce';
        });


    </script>



@endpush
