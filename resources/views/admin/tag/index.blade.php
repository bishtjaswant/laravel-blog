@extends('layouts.backend.app')


@section('title', 'Tag')


@push('css')
    <!-- JQuery DataTable Css -->
    <link href="{{ asset('assets/backend/') }}plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">

@endpush




@section('contents')

    <div class="container-fluid">
        <div class="block-header">
            <a href="{{ route('admin.tag.create') }}" class="btn btn-primary waves-effect">
             <l class="material-icons">add</l> <span>Add new tag</span>
            </a>
        </div>
        <!-- Exportable Table -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            ALL TAGS
                        </h2>

                    </div>

                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>TAG NAME</th>
                                    <th>TAG SLUGS</th>
                                    <th>CREATED AT</th>
                                    <th>UPDATED AT</th>
                                    @if(count($tags)> 0)
                                        <th colspan="2">ACTION</th>
                                    @endif

                                </tr>
                                </thead>

                                @if( count($tags)> 0)
                                    @foreach($tags as $key=>$tag )
                                        <tbody>
                                        <tr>
                                            <td> {{ $key + 1 }}</td>
                                            <td> {{ $tag->name }}</td>
                                            <td> {{ $tag->slug }}</td>
                                            <td> {{ $tag->created_at }}</td>
                                            <td> {{ $tag->updated_at }}</td>
                                            <td>
                                                <a href="{{ route('admin.tag.edit', $tag->id ) }}" class="btn btn-sm btn-primary">
                                                    <i class="material-icons">edit</i>
                                                </a>
                                                <a href="#" onclick="deleteTag({{ $tag->id }})" class="btn btn-sm btn-danger">
                                                    <i class="material-icons">delete</i>
                                                </a>

                                                <form action="{{route('admin.tag.destroy', $tag->id )}}" id="delete-tag-{{ $tag->id }}" style="display: none;" method="post">
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
                                                  <td colspan="7" class="text-danger text-center bg-danger">NO TAG YET</td>
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
@endpush
<script src="{{ asset('assets/backend') }}/plugins/jquery-datatable/extensions/export/buttons.print.min.js"></script>
<script src="{{asset('assets/backend')}}/js/pages/tables/jquery-datatable.js"> </script>
<script src="https://unpkg.com/sweetalert2@7.19.1/dist/sweetalert2.all.js"></script>

<script>
    function deleteTag(id) {


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
                document.getElementById('delete-tag-'+id).submit();
                swalWithBootstrapButtons(
                    'Deleted!',
                    'Your tag has been deleted.',
                    'success'
                )
            } else if (
                // Read more about handling dismissals
                result.dismiss === swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons(
                    'Cancelled',
                    'Your tag is safe :)',
                    'error'
                )
            }
        })

    }
</script>
