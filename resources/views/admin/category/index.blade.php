@extends('layouts.backend.app')


@section('title', 'Category')


@push('css')
    <!-- JQuery DataTable Css -->
    <link href="{{ asset('assets/backend/') }}plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">

@endpush




@section('contents')

    <div class="container-fluid">
        <div class="block-header">
            <a href="{{ route('admin.category.create') }}" class="btn btn-primary waves-effect">
             <l class="material-icons">add</l> <span>Add new Category</span>
            </a>
        </div>
        <!-- Exportable Table -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            ALL CATEGORIES
                        </h2>

                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>CATEGORY NAME</th>
                                    <th>CATEGORY SLUG </th>
                                    <th>CATEGORY IMAGE </th>
                                    <th>CREATED AT</th>
                                    {{--<th>UPDATED AT</th>--}}
                                    @if(count($categories)> 0)
                                        <th colspan="2">ACTION</th>
                                    @endif

                                </tr>
                                </thead>

                                @if( count($categories)> 0 )
                                    @foreach($categories as $key=>$category )
                                        <tbody>
                                        <tr>
                                            <td> {{ $key + 1 }}</td>
                                            <td> {{ $category->name }}</td>
                                            <td> {{ $category->slug }}</td>
                                            <td> {{ $category->image }}</td>
                                            <td> {{ $category->created_at }}</td>
{{--                                            <td> {{ $category->updated_at }}</td>--}}
                                            <td>
                                                <a href="{{ route('admin.category.edit', $category->id ) }}" class="btn btn-sm btn-primary">
                                                    <i class="material-icons">edit</i>
                                                </a>
                                                <a href="#" onclick="deleteCategory({{ $category->id }})" class="btn btn-sm btn-danger">
                                                    <i class="material-icons">delete</i>
                                                </a>

                                                <form action="{{route('admin.category.destroy', $category->id )}}" id="delete-category-{{ $category->id }}" style="display: none;" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </td>
                                        </tr>
                                        </tbody>
                                    @endforeach
                                    @else
                                          <tbody>
                                              <tr >
                                                  <td colspan="7" class="text-danger text-center bg-danger">NO CATEGORY YET</td>
                                              </tr>
                                          </tbody>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- #END# Exportable Table -->
    </div>

@endsection



@push('js')

    <!-- Jquery DataTable Plugin Js -->
    <script src="{{ asset('assets/backend') }}/plugins/jquery-datatable/jquery.dataTables.js"></script>
    <script src="{{ asset('assets/backend') }}/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
    <script src="{{ asset('assets/backend') }}/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js"></script>
    <script src="{{ asset('assets/backend') }}/plugins/jquery-datatable/extensions/export/buttons.flash.min.js"></script>
    <script src="{{ asset('assets/backend') }}/plugins/jquery-datatable/extensions/export/jszip.min.js"></script>
    <script src="{{ asset('assets/backend') }}/plugins/jquery-datatable/extensions/export/pdfmake.min.js"></script>
    <script src="{{ asset('assets/backend') }}/plugins/jquery-datatable/extensions/export/vfs_fonts.js"></script>
    <script src="{{ asset('assets/backend') }}plugins/jquery-datatable/extensions/export/buttons.html5.min.js"></script>
    <script src="{{ asset('assets/backend') }}/plugins/jquery-datatable/extensions/export/buttons.print.min.js"></script>
    <script src="{{asset('assets/backend')}}/js/pages/tables/jquery-datatable.js"> </script>
    <script src="https://unpkg.com/sweetalert2@7.19.1/dist/sweetalert2.all.js"></script>

    <script>
        function deleteCategory(id) {


            const swalWithBootstrapButtons = swal.mixin({
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
            })

            swalWithBootstrapButtons({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    event.preventDefault();
                    document.getElementById('delete-category-'+id).submit();
                    swalWithBootstrapButtons(
                        'Deleted!',
                        'Your category has been deleted.',
                        'success'
                    )
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons(
                        'Cancelled',
                        'Your category is safe :)',
                        'error'
                    )
                }
            })

        }
    </script>
@endpush