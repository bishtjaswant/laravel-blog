@extends('layouts.backend.app')


@section('title', 'Posts')


@push('css')
    <!-- JQuery DataTable Css -->
    <link href="{{ asset('assets/backend/') }}plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">

@endpush




@section('contents')

    <div class="container-fluid">

        <!-- Exportable Table -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                          PENDING POSTS &nbsp;&nbsp;  <span class="badge-info badge">{{ $pending->count() }}</span>
                        </h2>

                    </div>

                    @if( count($pending)> 0 )

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
                                    @if(count($pending)> 0)
                                        <th colspan="2">ACTION</th>
                                    @endif

                                </tr>
                                </thead>


                                    @foreach($pending as $key=>$post )
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
                                                <a href= "{{ route('admin.post.show', $post->id ) }}">
                                                    <i class="material-icons">visibility</i>
                                                </a>



                                                @if($post->is_approved == true )

                                                    <button disabled class="btn btn-sm btn-primary">
                                                        <i class="material-icons">done</i>
                                                    </button>
                                                @else

                                                    <a href="javascript:void()" onclick="approvalPost()" class="btn btn-sm btn-primary">
                                                        <i class="material-icons" title="this post is not approved yet">error</i>
                                                    </a>

                                                    <form id="aproval-post" action="{{ route('admin.post.approve', $post->id ) }}"  method="post" style="display: none;">
                                                        @csrf
                                                        @method('PUT')
                                                    </form>

                                                @endif




                                                <a href="{{ route('admin.post.edit', $post->id ) }}" class="btn btn-sm btn-primary">
                                                    <i class="material-icons">edit</i>
                                                </a>
                                                <a href="#" onclick="deletePost({{ $post->id }})" class="btn btn-sm btn-danger">
                                                    <i class="material-icons">delete</i>
                                                </a>

                                                <form action="{{route('admin.post.destroy', $post->id )}}" id="delete-post-{{ $post->id }}" style="display: none;" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </td>
                                        </tr>
                                        </tbody>
                                    @endforeach

                            </table>
                        </div>
                    </div>
                    @else
                        <div class="body">
                          <p class="text-capitalize text-center text-info bg-indigo">There are not any pending post to approve </p>
                        </div>
                        @endif
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









@endpush