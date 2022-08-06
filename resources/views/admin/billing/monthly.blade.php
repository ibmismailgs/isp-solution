<x-app-layout>
    @push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    @endpush
    @section('title', 'List of Monthly Bill')

    <x-slot name="header">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="fas fa-compass"></i>
                </div>
                <div>
                    <h4> List of Monthly Bill </h4>
                </div>
            </div>
        </div>
    </x-slot>

    <!-- Main Content -->
    <div class="container-fluid">
    	<div class="page-header">
            <div class="d-inline">
                @if (Session::has('message'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{Session::get('message')}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if (Session::has('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{Session::get('error')}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
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
                                    <th>Billing Month</th>
                                    <th>Total Subscriber</th>
                                    <th>Total Amount</th>
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
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script>
         $(document).ready( function () {
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
                url: "{{route('admin.monthly-bill')}}",
                type: "POST",
            },

            columns: [
            {
                "render": function() {
                    return i++;
                }
            },

            {data: 'billing_month', name: 'billing_month'},
            {data: 'total', name: 'total'},
            {data: 'total_amount', name: 'total_amount'},
            {data: 'action', searchable: false, orderable: false}
            ],

        });
    });

          // start delete function
        $('#example').on('click', '.btn-delete[data-remote]', function (e) {
            e.preventDefault();
            let url = $(this).data('remote');
            if (confirm('are you sure you want to delete this?')) {
                $.ajax({
                    url: url,
                    type: 'POST',
                    dataType: 'json',
                    data: {submit: true, _method: 'delete', _token: "{{ csrf_token() }}"}
                }).always(function (data) {
                    $('#example').DataTable().draw(false);
                });
            }
        });

    </script>
    @endpush
</x-app-layout>
