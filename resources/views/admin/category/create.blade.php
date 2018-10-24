@extends('layouts.backend.app')

@section('title','create category')

@push('css')
@endpush



@section('contents')
    <!-- Horizontal Layout -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Add new Category
                    </h2>

                </div>
                <div class="body">

                    <form enctype="multipart/form-data" class="form-horizontal" action="{{ route('admin.category.store') }}" method="post">

                        @csrf

                        <div class="row clearfix">
                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                <label for="category">Category name </label>
                            </div>
                            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" name="categoryName" id="category" class="form-control" placeholder="Type your Category name">
                                        @if($errors->any())
                                            @foreach($errors->all() as $error)
                                                <span class="text-danger"> {{$error }}</span>
                                            @endforeach
                                        @endif
                                        <span class="text-danger"> </span>

                                    </div>
                                </div>

                            </div>

                        </div>


                        {{--image--}}
                        <div class="row clearfix">
                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                <label for="image">Category image </label>
                            </div>
                            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="file" name="categoryImage" id="image" class="form-control">
                                        @if($errors->any())
                                            @foreach($errors->all() as $error)
                                                <span class="text-danger"> {{$error }}</span>
                                            @endforeach
                                        @endif
                                        <span class="text-danger"> </span>
                                    </div>
                                </div>

                            </div>

                        </div>



                        <div class="row clearfix">
                            <div class="col-lg-offset-2 col-md-offset-2 col-sm-offset-4 col-xs-offset-5">
                                <a href="{{route('admin.category.index')}}" class="btn btn-primary m-t-15 waves-effect">Back to category list </a>

                                <button type="submit" class="btn btn-primary m-t-15 waves-effect">Create Category</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- #END# Horizontal Layout -->
@endsection


@push('js')
@endpush