<x-app-layout>
    @push('css')
    <link rel="stylesheet" href="{{ asset('backend/plugins/DataTables/datatables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/extensions/toastr.css') }}">
    @endpush
    @section('title', 'Bill Pay')

    <x-slot name="header">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="fas fa-compass"></i>
                </div>
                <div>
                    <h4>List of Bill Pay</h4>
                </div>
            </div>
            <div class="page-title-actions">
                @can('bill_pay')
                    <a title="Create Button" href="{{ route('admin.bill-pay.create') }}" type="button" class="btn btn-sm btn-info">
                        <i class="fas fa-plus mr-1"></i>
                        Bill Pay
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
                        {{ Session::get('message') }}
                        <button title="Close Button" type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if (Session::has('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ Session::get('error') }}
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
                                <th>Date</th>
                                <th>Client ID</th>
                                <th>Name</th>
                                <th>Billing Month</th>
                                <th>Amount</th>
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
        $(document).ready( function () {
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
                url: "{{route('admin.all-bill-pay')}}",
                type: "post"
            },

            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'date', name: 'date'},
                {data: 'ClientId', name: 'ClientId'},
                {data: 'name', name: 'name'},
                {data: 'billing_month', name: 'billing_month'},
                {data: 'amount', name: 'amount'},
                {data: 'action', searchable: false, orderable: false}
            ],
            dom: "<'row'<'col-sm-2'l><'col-sm-7 text-center'B><'col-sm-3'f>>tipr",
                    buttons: [
                            {
                                extend: 'copy',
                                className: 'btn-sm btn-info',
                                title: 'Bill Pay',
                                header: true,
                                footer: true,
                                exportOptions: {
                                    columns: ['0,1,2,3,4,5'],
                                }
                            },
                            {
                                extend: 'csv',
                                className: 'btn-sm btn-success',
                                title: 'Bill Pay',
                                header: true,
                                footer: true,
                                exportOptions: {
                                    columns: ['0,1,2,3,4,5'],
                                }
                            },
                            {
                                extend: 'excel',
                                className: 'btn-sm btn-dark',
                                title: 'Bill Pay',
                                header: true,
                                footer: true,
                                exportOptions: {
                                    columns: ['0,1,2,3,4,5'],
                                }
                            },
                            {
                                extend: 'pdf',
                                className: 'btn-sm btn-primary',
                                title: 'Bill Pay',
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
                                title: 'Bill Pay',
                                pageSize: 'A2',
                                header: true,
                                footer: false,
                                orientation: 'landscape',
                                exportOptions: {
                                    columns: ['0,1,2,3,4,5'],
                                    stripHtml: false
                                }
                            }
                        ],
            });
        });

            $('#example').on('click', '.btn-delete[data-remote]', function(e) {
                e.preventDefault();
                let url = $(this).data('remote');
                if (confirm('are you sure, want to delete this?')) {
                    $.ajax({
                        url: url,
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            submit: true,
                            _method: 'delete',
                            _token: "{{ csrf_token() }}"
                        }
                    }).always(function(data) {
                        $('#example').DataTable().ajax.reload();
                        if (data) {
                            toastr.success('This data is successfully deleted.', {
                                positionClass: 'toast-bottom-full-width',
                            });
                            return false;
                        } else {
                            toastr.error('Error!!. This data is not deleted.', {
                                positionClass: 'toast-bottom-full-width',
                            });
                            return false;
                        }
                    });
                }
            });
        </script>
    @endpush
</x-app-layout>
