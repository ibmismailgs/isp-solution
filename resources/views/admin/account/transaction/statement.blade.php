<x-app-layout>
    @push('css')
    <link rel="stylesheet" href="{{ asset('backend/plugins/DataTables/datatables.min.css') }}">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    @endpush

    @section('title', 'Account Statement')
    <x-slot name="header">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="fas fa-compass"></i>
                </div>
                <div>
                    <h4>Account Statement</h4>
                </div>
            </div>

        </div>
    </x-slot>

    <!-- Main Content -->
    <div class="container-fluid">
        <div class="page-header">
            <div class="d-inline">
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
        <div class="card">
            <div class="card-body">

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="account_id"> Account Name <span class="text-red">*</span>
                                <span class="text-info" id="balance" style="display: none"> </span>
                            </label>

                            <select name="account_id" id="account_id" class="form-control" onchange="getBalance()">
                                <option value="">Select Account Name</option>
                                @foreach ($accounts as $key => $item)
                                    <option value="{{ $item->id }}"> {{ $item->name }} </option>
                                @endforeach
                            </select>

                            @error('account_id')
                                <span class="text-danger" role="alert">
                                    <p>{{ $message }}</p>
                                </span>
                            @enderror

                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="start_date"> From Date <span class="text-red">*</span></label>
                            <input type="text" name="start_date" id="start_date" value="{{ old('start_date') }}"
                                class="form-control datepicker @error('start_date') is-invalid @enderror"
                                placeholder="Enter start date" required>

                            @error('stattement_date')
                                <span class="text-danger" role="alert">
                                    <p>{{ $message }}</p>
                                </span>
                            @enderror

                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="end_date"> To Date <span class="text-red">*</span></label>
                            <input type="text" name="end_date" id="end_date" value="{{ old('end_date') }}"
                                class="form-control datepicker @error('end_date') is-invalid @enderror"
                                placeholder="Enter end date" required>

                            @error('end_date')
                                <span class="text-danger" role="alert">
                                    <p>{{ $message }}</p>
                                </span>
                            @enderror

                        </div>
                    </div>


                </div>

                <div class="row mt-30">
                    <div class="col-sm-12">
                        <button title="Search Button" type="submit" id="search" class="btn btn-sm btn-primary float-left search"><i class="fa fa-search"></i> Search</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <table id="example" class="table table-hover table-bordered ">
                            <thead>

                                <tr id="previous_tr" class="btn-primary" style="display: none">
                                    <td colspan="2"> Previous Balance</td>
                                    <td><b id="prevBalance"> </b> BDT</td>
                                </tr>

                                <tr>
                                    <th> SN </th>
                                    <th> Transaction Date </th>
                                    <th> Transaction Reason </th>
                                    <th> Credit (BDT) </th>
                                    <th> Debit (BDT) </th>
                                    <th> Current Balance (BDT) </th>
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
        <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
        <script>
            // date picker
            $('.datepicker').datepicker({
                dateFormat: 'dd MM yy'
            });


            $('#search').on('click', function(event) {
                event.preventDefault();
                var start_date = $("#start_date").val();
                var end_date = $("#end_date").val();
                var account_id = $("#account_id").val();
                var x = 1;

                if (start_date !== '' && end_date !== '' && account_id !== '') {

                    var table = $('#example').DataTable({
                        order: [],
                        lengthMenu: [
                            [10, 25, 50, 100, -1],
                            [10, 25, 50, 100, "All"]
                        ],
                        processing: true,
                        serverSide: true,
                        "bDestroy": true,
                        language: {
                            processing: '<i class="ace-icon fa fa-spinner fa-spin orange bigger-500" style="font-size:60px;margin-top:50px;"></i>'
                        },

                        ajax: {
                            url: "{{ route('admin.account-statements') }}",
                            type: "POST",
                            data: {
                                'start_date': start_date,
                                'end_date': end_date,
                                'account_id': account_id,
                            },
                        },
                        columns: [
                           {
                            "render": function() {
                                return x++;
                            }
                        },
                        {data: 'transaction_date', name: 'transaction_date'},
                        {data: 'transaction_reason', name: 'transaction_reason'},
                        {data: 'credit', name: 'credit'},
                        {data: 'debit', name: 'debit'},
                        {data: 'current_balance', name: 'current_balance'},
                        ],
                        dom: "<'row'<'col-sm-2'l><'col-sm-7 text-center'B><'col-sm-3'f>>tipr",
                        buttons: [
                            {
                                extend: 'copy',
                                className: 'btn-sm btn-info',
                                title: 'Expenses',
                                header: true,
                                footer: true,
                                exportOptions: {
                                    columns: ['0,1,2,3,4,5'],
                                }
                            },
                            {
                                extend: 'csv',
                                className: 'btn-sm btn-success',
                                title: 'Expenses',
                                header: true,
                                footer: true,
                                exportOptions: {
                                    columns: ['0,1,2,3,4,5'],
                                }
                            },
                            {
                                extend: 'excel',
                                className: 'btn-sm btn-dark',
                                title: 'Expenses',
                                header: true,
                                footer: true,
                                exportOptions: {
                                    columns: ['0,1,2,3,4,5'],
                                }
                            },
                            {
                                extend: 'pdf',
                                className: 'btn-sm btn-primary',
                                title: 'Expenses',
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
                                title: 'Expenses',
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
                        initComplete: function(data) {
                            var prevBalance = data.json.prevBalance;
                            $('#previous_tr').show()
                            document.getElementById('prevBalance').innerHTML = prevBalance;
                        },

                        order: [
                            [0, 'asc']
                        ]
                    });
                } else {
                    alert('Enter All Data')
                }
            });



            function getBalance() {
                var accountId = $('#account_id').val();
                if (accountId !== null) {
                    var url = '{{ route('admin.account-initial-balance', ':id') }}';
                    $.ajax({
                        type: "GET",
                        url: url.replace(':id', accountId),
                        success: function(resp) {
                            $('#balance').show();
                            document.getElementById('balance').innerHTML = '( ' + resp + ' )';
                            $('#amount_balance').val(resp);
                        }, // success end
                        error: function(error) {
                        }
                    })
                }
            }
            //  get balance End
        </script>
    @endpush
</x-app-layout>
