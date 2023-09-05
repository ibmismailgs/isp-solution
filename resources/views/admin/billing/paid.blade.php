<x-app-layout>
    @push('css')
    <link rel="stylesheet" href="{{ asset('backend/plugins/DataTables/datatables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/extensions/toastr.css')}}">
    @endpush
    @section('title', 'Paid-Clients')

    <x-slot name="header">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="fas fa-compass"></i>
                </div>
                <div>
                    <h4>List of Paid-Clients</h4>
                </div>
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
                                    <th>Client Name</th>
                                    <th>Package Name</th>
                                    <th>Amount</th>
                                    <th>IP Address</th>
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
    <script src="{{ asset('backend/plugins/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/extensions/toastr.min.js') }}"></script>
    <script>
        var i = 1;
        var dTable = $('#example').DataTable({
            order: [],
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            processing: true,
            serverSide: true,
            "bDestroy": true,
            language: {
            processing: '<i class="ace-icon fa fa-spinner fa-spin orange bigger-500" style="font-size:60px;margin-top:50px;"></i>'
            },

            ajax: {
                url: "{{route('admin.paid-clients')}}",
                type: "POST",
            },

            columns: [
            {
                "render": function() {
                    return i++;
                }
            },

            {data: 'subscribers.subscriber_id', name: 'subscribers'},
            {data: 'subscribers.name', name: 'subscribers'},
            {data: 'packages.name', name: 'packages'},
            {data: 'total_amount', name: 'total_amount'},
            {data: 'subscribers.ip_address', name: 'subscribers'},
            {data: 'action', searchable: false, orderable: false}
            ],
            dom: "<'row'<'col-sm-2'l><'col-sm-7 text-center'B><'col-sm-3'f>>tipr",
                    buttons: [
                            {
                                extend: 'copy',
                                className: 'btn-sm btn-info',
                                title: 'Paid-Clients',
                                header: true,
                                footer: true,
                                exportOptions: {
                                    columns: ['0,1,2,3,4,5'],
                                }
                            },
                            {
                                extend: 'csv',
                                className: 'btn-sm btn-success',
                                title: 'Paid-Clients',
                                header: true,
                                footer: true,
                                exportOptions: {
                                    columns: ['0,1,2,3,4,5'],
                                }
                            },
                            {
                                extend: 'excel',
                                className: 'btn-sm btn-dark',
                                title: 'Paid-Clients',
                                header: true,
                                footer: true,
                                exportOptions: {
                                    columns: ['0,1,2,3,4,5'],
                                }
                            },
                            {
                                extend: 'pdf',
                                className: 'btn-sm btn-primary',
                                title: 'Paid-Clients',
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
                                title: 'Paid-Clients',
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

        });

    </script>
    @endpush
</x-app-layout>
