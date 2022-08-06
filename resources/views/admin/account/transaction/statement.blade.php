<x-app-layout>
    @push('css')
        <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
         <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">

          {{-- <style>
            .ui-datepicker-calendar {
                display: none;
            }
        </style> --}}
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
            {{-- <div class="page-title-actions">
                <a href="{{ route('admin.bank.index') }}" type="button" class="btn btn-sm btn-dark">
                    <i class="fas fa-arrow-left mr-1"></i>
                    Back
                </a>
            </div> --}}
        </div>
    </x-slot>

    <!-- Main Content -->
    <div class="container-fluid">
         <div class="page-header">
            <div class="d-inline">
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
        <div class="card">
            <div class="card-body">
                {{-- <form action="{{ route('admin.account-statements') }}" method="POST">
                    @csrf --}}
                            <div class="row">

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="account_id"> Account Name <span class="text-red">*</span></label>

                                        <select name="account_id" id="account_id" class="form-control" >
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

                               {{-- <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="statement_date"> Choose Month <span class="text-red">*</span></label>
                                        <input type="text" name="statement_date" id="statement_date" value="{{ old('statement_date') }}" class="form-control statement_date @error('statement_date') is-invalid @enderror" placeholder="Enter statement date" required>

                                        @error('statement_date')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div> --}}

                               <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="start_date"> From Date <span class="text-red">*</span></label>
                                        <input type="text" name="start_date" id="start_date" value="{{ old('start_date') }}" class="form-control datepicker @error('start_date') is-invalid @enderror" placeholder="Enter start date"  required>

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
                                        <input type="text" name="end_date" id="end_date" value="{{ old('end_date') }}" class="form-control datepicker @error('end_date') is-invalid @enderror" placeholder="Enter end date" required>

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
                                    <button type="submit" id="search" class="btn btn-sm btn-success float-left search"><i class="fa fa-search"></i> Search</button>
                                </div>
                            </div>
                        {{-- </form> --}}
                </div>
            </div>

            <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <table id="example" class="table table-hover table-bordered ">
                            <thead>
                                <tr>
                                    <th> SN </th>
                                    <th> Transaction Date </th>
                                    <th> Account Name </th>
                                    <th> Account No </th>
                                    <th> Bank Name </th>
                                    <th> Initial Balance (BDT) </th>
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
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
     <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
    <script>
        // date picker
        $('.datepicker').datepicker({
            dateFormat: 'dd MM yy'
        });

        //  $('.statement_date').datepicker( {
        //     changeMonth: true,
        //     changeYear: true,
        //     showButtonPanel: true,
        //     yearRange:"-30:+100",
        //     dateFormat: 'dd MM yy',
        //     onClose: function(dateText, inst) {
        //         $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
        //     }
        //     });


          $('#search').on('click',function(event){
             event.preventDefault();
               var start_date = $("#start_date").val();
               var end_date = $("#end_date").val();
               var account_id = $("#account_id").val();
                var x = 1;

            var table =  $('#example').DataTable({
                order: [],
                    lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                    processing: true,
                    serverSide: true,
                    "bDestroy": true,
                    language: {
                    processing: '<i class="ace-icon fa fa-spinner fa-spin orange bigger-500" style="font-size:60px;margin-top:50px;"></i>'
                    },

                    ajax: {
                    url: "{{route('admin.account-statements')}}",
                    type: "POST",
                    data:{
                            'start_date':start_date,
                            'end_date':end_date,
                            'account_id':account_id,
                        },
                    },
                    columns: [
                        {
                            "render": function() {
                                return x++;
                            }
                        },
                        {data: 'transaction_date', name: 'transaction_date'},
                        {data: 'accounts.name', name: 'accounts'},
                        {data: 'accounts.account_no', name: 'accounts'},
                        {data: 'bank', name: 'bank'},
                        {data: 'accounts.initial_balance', name: 'initial_balance'},
                        {data: 'credit', name: 'credit'},
                        {data: 'debit', name: 'debit'},
                        {data: 'current_balance', name: 'current_balance'},
                    ],
                 order: [[0, 'asc']]
            });
        });

    </script>
    @endpush
</x-app-layout>
