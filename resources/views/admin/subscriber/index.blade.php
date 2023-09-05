<x-app-layout>
    @push('css')
    <link rel="stylesheet" href="{{ asset('backend/plugins/DataTables/datatables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/extensions/toastr.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css" integrity="sha512-O03ntXoVqaGUTAeAmvQ2YSzkCvclZEcPQu1eqloPaHfJ5RuNGiS4l+3duaidD801P50J28EHyonCV06CUlTSag==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @endpush
    @section('title', 'Client List')

    <x-slot name="header">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="fas fa-compass"></i>
                </div>
                <div>
                    <h4>List of Clients</h4>
                </div>
            </div>
            <div class="page-title-actions">

                <a title="Download Button" href="{{ route('admin.subscriber.sample-excel') }}" type="button" class="btn btn-sm btn-info">
                    Sample Excel Download
                </a>

            </div>
            <div class="page-title-actions">
                <form action="{{route('admin.subscriber.import')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div>
                        <input type="file" name="import_file" required>
                        <input type="submit" class="btn-sm btn btn-success" value="Import">
                    </div>
                </form>
            </div>
            <div class="page-title-actions">
                 @can('client_create')
                    <a title="Create Button" href="{{ route('admin.subscriber.create') }}" type="button" class="btn btn-sm btn-info">
                        <i class="fas fa-plus mr-1"></i>
                        Create
                    </a>
                 @endcan
            </div>
        </div>
    </x-slot>

    <div class="container-fluid">
    	<div class="page-header">
            <div class="d-inline">
                @if (Session::has('message'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{Session::get('message')}}
                        <button title="Close Button" type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                 @if (Session::has('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{Session::get('error')}}
                    <button title="Close Button" type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif

            </div>
        </div>
    </div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <table id="example" class="table table-hover table-bordered ">
                            <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Client ID</th>
                                    <th>Name</th>
                                    <th>Area</th>
                                    <th>Package</th>
                                    <th>IP Address</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
    @push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js" integrity="sha512-Zq9o+E00xhhR/7vJ49mxFNJ0KQw1E1TMWkPTxrWcnpfEFDEXgUiwJHIKit93EW/XxE31HSI5GEOW06G6BF1AtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('backend/plugins/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/extensions/toastr.min.js') }}"></script>
    <script>

        $(document).ready( function () {
        var searchable = [];
        var selectable = [];

        var dTable = $('#example').DataTable({
            order: [],
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            processing: true,
            responsive: false,
            serverSide: true,
            scroller: {
                loadingIndicator: false
            },
            pagingType: "full_numbers",
            ajax: {
                url: "{{route('admin.all-subscriber')}}",
                type: "post"
            },

            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'subscriber_id', name: 'subscriber_id'},
                {data: 'name', name: 'name'},
                {data: 'area_name', name: 'area_name'},
                {data: 'package_name', name: 'package_name'},
                {data: 'ip_address', name: 'ip_address'},
                {data: 'status', searchable: false, orderable: false},
                {data: 'action', searchable: false, orderable: false}

            ],
            dom: "<'row'<'col-sm-2'l><'col-sm-7 text-center'B><'col-sm-3'f>>tipr",
                    buttons: [
                            {
                                extend: 'copy',
                                className: 'btn-sm btn-info',
                                title: 'Clients',
                                header: true,
                                footer: true,
                                exportOptions: {
                                    columns: ['0,1,2,3,4,5'],
                                }
                            },
                            {
                                extend: 'csv',
                                className: 'btn-sm btn-success',
                                title: 'Clients',
                                header: true,
                                footer: true,
                                exportOptions: {
                                    columns: ['0,1,2,3,4,5'],
                                }
                            },
                            {
                                extend: 'excel',
                                className: 'btn-sm btn-dark',
                                title: 'Clients',
                                header: true,
                                footer: true,
                                exportOptions: {
                                    columns: ['0,1,2,3,4,5'],
                                }
                            },
                            {
                                extend: 'pdf',
                                className: 'btn-sm btn-primary',
                                title: 'Clients',
                                pageSize: 'A2',
                                header: true,
                                footer: true,
                                exportOptions: {
                                    columns: ['0,1,2,3,4,5'],
                                }
                            },
                            {
                                extend: 'print',
                                className: 'btn-sm btn-danger',
                                title: 'Clients',
                                pageSize: 'A2',
                                header: true,
                                footer: true,
                                orientation: 'landscape',
                                exportOptions: {
                                    columns: ['0,1,2,3,4,5'],
                                    stripHtml: false
                                }
                            }
                        ],
                columnDefs: [{
                    targets: [4],
                    orderable: false
                }]
            });
        });

        $('#example').on('click', '.btn-delete[data-remote]', function (e) {
            e.preventDefault();

            const url = $(this).data('remote');
            swal({
                title: `Are you sure you want to delete this record?`,
                text: "If you delete this, it will be gone forever.",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
          if (willDelete) {
            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                data: {submit: true, _method: 'delete', _token: "{{ csrf_token() }}"}
            }).always(function (data) {
                $('#example').DataTable().ajax.reload();
                if(data){
                    toastr.success('This data is successfully deleted.', { positionClass: 'toast-bottom-full-width', });
                    return false;
                }else{
                    toastr.error('Error!!. This data is not deleted.', { positionClass: 'toast-bottom-full-width', });
                    return false;
                }
            });
          }
        });
    });


   $('.card').on('click', '.changeStatus', function (e) {
        e.preventDefault();

        var id = $(this).attr('getId');
            swal({
                title: `Are you sure you ?`,
                text: `Want to change this status?`,
                buttons: true,
                dangerMode: true,
            }).then((statusChange) => {
          if (statusChange) {
            $.ajax({
                'url':"{{ route('admin.subscriber-status') }}",
                'type':'post',
                'dataType':'text',
                'data':{id:id},
                success:function(data)
                {
                    $('#example').DataTable().ajax.reload();
                    if(data == "success"){
                        toastr.success('This status has been changed to Active.', { positionClass: 'toast-bottom-full-width', });
                        return false;
                    }else{
                        toastr.error('This status has been changed to Inctive.', { positionClass: 'toast-bottom-full-width', });
                        return false;
                    }
                }
            });
          }
        });
    })

    </script>

    @endpush
</x-app-layout>
