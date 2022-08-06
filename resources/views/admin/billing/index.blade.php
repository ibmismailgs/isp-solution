<x-app-layout>
    @push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
        <style>
            .ui-datepicker-calendar {
            display: none;
        }
        </style>
    @endpush
    @section('title', 'Bill Process')

    <x-slot name="header">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="fas fa-compass"></i>
                </div>
                <div>
                    <h4>Bill Process</h4>
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
            <form action="{{ route('admin.bill-generate') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="billing_month"> Billing Month <span class="text-red">*</span></label>
                            <input type="text" name="billing_month" id="billing_month" value="{{ old('billing_month') }}" class="form-control datepicker  @error('billing_month') is-invalid @enderror" placeholder="Enter billing month" >

                            @error('billing_month')
                                <span class="text-danger" role="alert">
                                    <p>{{ $message }}</p>
                                </span>
                            @enderror
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="bill_description">Description</label>
                        <textarea name="bill_description" id="bill_description" style="height: 38px" class="form-control" placeholder="Enter your description">{!! old('bill_description') !!}</textarea>
                    </div>
                </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <button class="btn btn-primary btn-sm" type="submit" id="search" name="search"><i class="fa fa-search"></i> Search</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                       <form action="{{route('admin.bill.store')}}" method="POST">
                        @csrf
                         <table id="example" class="table table-hover table-bordered ">
                            <thead>
                                <tr>
                                    <th>Subscriber ID</th>
                                    <th>Subscriber Name</th>
                                    <th>Package Name</th>
                                    <th>Package Amount</th>
                                    <th>Bill Status</th>
                                    <th>Bill Adjust</th>
                                    <th>Extra Add/Sub </th>
                                    <th>Used Days</th>
                                    <th>Total Amount</th>
                                </tr>
                            </thead>

                            <tbody>

                            </tbody>
                        </table>
                        <input type="hidden" name="bill_month" id="bill_month">
                        <textarea hidden="hidden" name="description" id="description" style="height: 38px" class="form-control" placeholder="Enter your description">{!! old('bill_description') !!}</textarea>
                        <button onclick="Message('are you sure ?')" type="submit" id="generate" class="btn btn-success generate">Generate</button>
                       </form>

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
        $(function() {
            $('.datepicker').datepicker( {
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            yearRange:"-30:+100",
            dateFormat: 'MM-yy',
            onClose: function(dateText, inst) {
                $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
            }
            });
        });

        var billing_month = '';
        var description = '';
          $('#search').on('click',function(event){

             event.preventDefault();
            billing_month = $("#billing_month").val();
            bill_description = $("#bill_description").val();
             var search = $("#search").val();

            $.ajax({
                url: "{{ route('admin.bill-generate') }}",
                type:"POST",
                data:{
                    'billing_month':billing_month,
                },
                success: function(result){
                    if(result == 1){
                    $('#example').DataTable().clear().destroy();
                        alert('Bill Already Generated');
                    }
                    else{

                        $('#bill_month').val(billing_month);
                        $('#description').val(bill_description);

                        var x = 1;

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
                                url: "{{route('admin.billing-month')}}",
                                type: "POST",
                                data:{
                                    'billing_month':billing_month,
                                },
                            },

                            columns: [
                                {data: 'subscriber_id', name: 'subscriber_id'},
                                {data: 'name', name: 'name'},
                                {data: 'packages.name', name: 'packages'},
                                {data: 'packages.amount', name: 'packages'},
                                {data: 'status', name: 'status'},
                                {data: 'add_sub', name: 'add_sub'},
                                {data: 'input', name: 'input'},
                                {data: 'used_day', name: 'used_day'},
                                {data: 'amount', name: 'amount'},

                            ],

                        });
                    }
                    }});
            });

            // bill calculate

          function calculation(id){

            var add_sub = $('#add_sub'+id).val();
            if(add_sub == 1){

            var adjust_bill = $('#adjust_bill'+id).val();
            var total = $('#prev_amount'+id).val();
            var sum =  parseFloat(total)  + parseFloat(adjust_bill) ;
            $('#total_amount'+id).val(sum);

            }else if(add_sub == 2){

            var adjust_bill = $('#adjust_bill'+id).val();
            var total = $('#prev_amount'+id).val();
            var sum =  parseFloat(total) - parseFloat(adjust_bill) ;
            $('#total_amount'+id).val(sum);
            }
        };

          function addSub(value){

            var add_sub = $('#add_sub'+value).val();
            if(add_sub == 1){

            var adjust_bill = $('#adjust_bill'+value).val();
            var total = $('#prev_amount'+value).val();
            var sum =  parseFloat(total)  + parseFloat(adjust_bill) ;
            $('#total_amount'+value).val(sum);

            } else if(add_sub == 2){

            var adjust_bill = $('#adjust_bill'+value).val();
            var total = $('#prev_amount'+value).val();
            var sum =  parseFloat(total) - parseFloat(adjust_bill) ;
            $('#total_amount'+value).val(sum);
            }
        };

    </script>
    @endpush
</x-app-layout>
