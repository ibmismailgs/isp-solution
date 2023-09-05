<x-app-layout>
    @push('css')
        <link rel="stylesheet" href="{{ asset('backend/plugins/DataTables/datatables.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/extensions/toastr.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css" integrity="sha512-O03ntXoVqaGUTAeAmvQ2YSzkCvclZEcPQu1eqloPaHfJ5RuNGiS4l+3duaidD801P50J28EHyonCV06CUlTSag==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @endpush
    @section('title', 'Deposit/Withdraw')

    <x-slot name="header">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="fas fa-compass"></i>
                </div>
                <div>
                    <h4>List of Deposit/Withdraw</h4>
                </div>
            </div>
            <div class="page-title-actions">
                @can('deposit_withdraw_create')
                    <a title="Create Button" href="{{ route('admin.transactions.create') }}" type="button" class="btn btn-sm btn-info">
                        <i class="fas fa-plus mr-1"></i>
                        Create
                    </a>
                @endcan

            </div>
        </div>
    </x-slot>

    <!-- Main Content -->
    <div class="container-fluid">
        <div class="page-header">
            <div class="d-inline">
                @if (Session::has('message'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ Session::get('message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if (Session::has('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ Session::get('error') }}
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
                                <th>Account Name</th>
                                <th>Account No</th>
                                <th>Bank Name</th>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js" integrity="sha512-Zq9o+E00xhhR/7vJ49mxFNJ0KQw1E1TMWkPTxrWcnpfEFDEXgUiwJHIKit93EW/XxE31HSI5GEOW06G6BF1AtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="{{ asset('backend/plugins/DataTables/datatables.min.js') }}"></script>
        <script src="{{ asset('app-assets/vendors/js/extensions/toastr.min.js') }}"></script>
        <script>
            $(document).ready(function() {
                var i = 1;

                var dTable = $('#example').DataTable({
                    order: [],
                    lengthMenu: [
                        [10, 25, 50, 100, -1],
                        [10, 25, 50, 100, "All"]
                    ],
                    processing: true,
                    responsive: false,
                    serverSide: true,
                    scroller: {
                        loadingIndicator: false
                    },
                    pagingType: "full_numbers",
                    ajax: {
                        url: "{{ route('admin.transaction-list') }}",
                        type: "post"
                    },

                    columns: [

                        { data: 'DT_RowIndex', name: 'DT_RowIndex'},
                        {
                            data: 'account_name',
                            name: 'account_name'
                        },
                        {
                            data: 'account_no',
                            name: 'account_no'
                        },
                        {
                            data: 'bank',
                            name: 'bank'
                        },
                        {
                            data: 'transaction_amount',
                            name: 'transaction_amount'
                        },

                        {
                            data: 'action',
                            searchable: false,
                            orderable: false
                        }

                    ],
                    dom: "<'row'<'col-sm-2'l><'col-sm-7 text-center'B><'col-sm-3'f>>tipr",
                    buttons: [
                            {
                                extend: 'copy',
                                className: 'btn-sm btn-info',
                                title: 'List Of Deposit/Withdraw',
                                header: true,
                                footer: true,
                                exportOptions: {
                                    columns: ['0,1,2,3,4'],
                                }
                            },
                            {
                                extend: 'csv',
                                className: 'btn-sm btn-success',
                                title: 'List Of Deposit/Withdraw',
                                header: true,
                                footer: true,
                                exportOptions: {
                                    columns: ['0,1,2,3,4'],
                                }
                            },
                            {
                                extend: 'excel',
                                className: 'btn-sm btn-dark',
                                title: 'List Of Deposit/Withdraw',
                                header: true,
                                footer: true,
                                exportOptions: {
                                    columns: ['0,1,2,3,4'],
                                }
                            },
                            {
                                extend: 'pdf',
                                className: 'btn-sm btn-primary',
                                title: 'List Of Deposit/Withdraw',
                                pageSize: 'A2',
                                header: true,
                                footer: true,
                                exportOptions: {
                                    columns: ['0,1,2,3,4'],
                                }
                            },
                            {
                                extend: 'print',
                                className: 'btn-sm btn-danger',
                                title: 'List Of Deposit/Withdraw',
                                // orientation:'landscape',
                                pageSize: 'A2',
                                header: true,
                                footer: true,
                                orientation: 'landscape',
                                exportOptions: {
                                    columns: ['0,1,2,3,4'],
                                    stripHtml: false
                                }
                            }
                        ],

                });
            });

            // start delete function
            $('#example').on('click', '.btn-delete[data-remote]', function (e) {
        e.preventDefault();

        const url = $(this).data('remote');//cancel default action
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

        </script>
    @endpush
</x-app-layout>
