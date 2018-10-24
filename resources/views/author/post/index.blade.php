@extends('layouts.backend.app')


@section('title', 'Posts')


@push('css')
    <!-- JQuery DataTable Css -->
    <link href="{{ asset('assets/backend/') }}plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">

@endpush




@section('contents')

    <div class="container-fluid">
        <div class="block-header">
            <a href="{{ route('author.post.create') }}" class="btn btn-primary waves-effect">
             <l class="material-icons">add</l> <span>Add new Post</span>
            </a>
        </div>
        <!-- Exportable Table -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            ALL POSTS &nbsp;&nbsp;  <span class="badge-info badge">{{ $posts->count() }}</span>
                        </h2>

                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>AUTHOR</th>
                                    <th>TITLE</th>
                                    <th>STATUS</th>
                                    <th>APPROVED</th>

                                    {{--<th>UPDATED AT</th>--}}
                                    @if(count($posts)> 0)
                                        <th colspan="2">ACTION</th>
                                    @endif

                                </tr>
                                </thead>

                                @if( count($posts)> 0 )
                                    @foreach($posts as $key=>$post )
                                        <tbody>
                                        <tr>
                                            <td> {{ $key + 1 }}</td>
                                            <td> {{ $post->user->name }}  </td>
                                            <td> {{ str_limit($post->title, '20') }}</td>

                                            <td>
                                                @if($post->status == true)
                                                    <span class="badge bg-blue">Active</span>
                                                @else
                                                    <span class="badge bg-brown">Inactive</span>
                                                @endif
                                            </td>

                                            <td>
                                               @if($post->is_approved	== true)
                                                   <span class="badge bg-green">Appoved</span>
                                               @else
                                                   <span class="badge bg-red">Pending....</span>
                                               @endif

                                            </td>

                                            <td>
                                                <a href= "{{ route('author.post.show', $post->id ) }}">
                                                    <i class="material-icons">visibility</i>
                                                </a>
                                                <a href="{{ route('author.post.edit', $post->id ) }}" class="btn btn-sm btn-primary">
                                                    <i class="material-icons">edit</i>
                                                </a>
                                                <a href="#" onclick="deletePost({{ $post->id }})" class="btn btn-sm btn-danger">
                                                    <i class="material-icons">delete</i>
                                                </a>

                                                <form action="{{route('author.post.destroy', $post->id )}}" id="delete-post-{{ $post->id }}" style="display: none;" method="post">
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
                                                  <td colspan="9" class="text-danger text-center bg-danger">NO POSTS YET</td>
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
        function deletePost(id) {


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
                    document.getElementById('delete-post-'+id).submit();
                    swalWithBootstrapButtons(
                        'Deleted!',
                        'Your post has been deleted.',
                        'success'
                    )
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons(
                        'Cancelled',
                        'Your post is safe :)',
                        'error'
                    )
                }
            })

        }
    </script>
@endpush