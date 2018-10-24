@extends('layouts.backend.app')

@section('title','create tag')

@push('css')
@endpush



@section('contents')
    <!-- Horizontal Layout -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Add new tag
                    </h2>

                </div>
                <div class="body">
                    <form class="form-horizontal" action="{{ route('admin.tag.store') }}" method="post">

                        @csrf

                        <div class="row clearfix">
                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                <label for="tag">Tag name </label>
                            </div>
                            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" name="tagName" id="tag" class="form-control" placeholder="Enter your tags name">
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
                                <a href="{{route('admin.tag.index')}}" class="btn btn-primary m-t-15 waves-effect">Back to tag list </a>

                                <button type="submit" class="btn btn-primary m-t-15 waves-effect">Create tag</button>
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