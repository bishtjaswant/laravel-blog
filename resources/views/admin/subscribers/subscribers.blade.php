@extends('layouts.backend.app')


@section('title', 'Subscribers')


@push('css')
    <!-- JQuery DataTable Css -->
    <link href="{{ asset('assets/backend/') }}plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">

@endpush




@section('contents')

        @if( count($subscribers) > 0 )
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Subscribers  &nbsp;&nbsp; <span class="badge-info badge">  {{ $subscribers->count() }} </span>
                        </h2>

                    </div>
                    <div class="body table-responsive">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Subbscribed Email</th>
                                <th>Subscribed on</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach( $subscribers as $key=>$subscriber )
                                <tr>
                                    <td> {{ $key + 1 }}  </td>
                                    <td> {{ $subscriber->email }}  </td>
                                    <td> {{ $subscriber->created_at->toFormattedDateString() }} </td>
                                    <td>
                                        <a href="javascript:void(0)" onclick="deleteSubscription()" title="want to remove this subscription" class="btn btn-danger btn-sm glyphicon glyphicon-remove"></a>
                                        <form action="{{ route('admin.subscribe.delete', $subscriber->id  ) }}" id="removeSubscription" style="display: none;" method="post">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @else

            <div class="card">
                <div class="body">
                    <p class="bg-info text-info"> NO SUBSCRIBERS</p>
                </div>
            </div>

        @endif

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
        function deleteSubscription(  ) {


            const swalWithBootstrapButtons = swal.mixin({
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
            })

            swalWithBootstrapButtons({
                title: 'Are you sure want to remove this subscription?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    event.preventDefault();
                    document.getElementById('removeSubscription').submit();
                    swalWithBootstrapButtons(
                        'Deleted!',
                        'Subscription removed.',
                        'success'
                    )
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons(
                        'Cancelled',
                        'Your \'ve cancelled the remove subscription  :)',
                        'error'
                    )
                }
            })

        }
    </script>







@endpush