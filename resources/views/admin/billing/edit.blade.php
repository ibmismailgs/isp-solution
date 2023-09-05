<x-app-layout>
    @section('title', 'Edit Billing Information')
    <x-slot name="header">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="fas fa-compass"></i>
                </div>
                <div>
                    <h4> Edit Billing Information </h4>
                </div>
            </div>
            <div class="page-title-actions">
                <a title="Back Button" href="{{ route('admin.bill.index') }}" type="button" class="btn btn-sm btn-dark">
                    <i class="fas fa-arrow-left mr-1"></i>
                    Back
                </a>
            </div>
        </div>
    </x-slot>

    <div class="container-fluid">
        <div class="page-header">
            <div class="d-inline">
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
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <form action="{{ route('admin.bill.update', $data->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="subscriber_id">Subscriber ID<span class="text-red">*</span></label>
                                        <input type="text" name="subscriber_id" id="subscriber_id" value="{{ $data->subscribers->subscriber_id }}" class="form-control" readonly>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="name">Subscriber Name<span class="text-red">*</span></label>
                                        <input type="text" name="name" id="name" value="{{  $data->subscribers->name }}" class="form-control" readonly>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="package_id">Package Name<span class="text-red">*</span></label>
                                        <input type="text" name="package_id" id="package_id" value="{{  $data->packages->name }}" class="form-control " readonly>

                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="name">Package Amount<span class="text-red">*</span></label>
                                        <input type="text" name="amount" id="amount" value="{{ $data->packages->amount }}" class="form-control " readonly>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="status"> Bill Status <span class="text-red">*</span></label>
                                        <select name="status" id="status" class="form-control">
                                            <option value="1" {{ $data->status == 1 ? 'selected' : '' }}>Paid</option>
                                            <option value="0" {{ $data->status == 0 ? 'selected' : '' }}>Unpaid</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="status"> Account </label>
                                        <select name="account_id" id="account_id" class="form-control">

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
                                        <label for="add_sub"> Adjust Bill <span class="text-red">*</span></label>

                                        <select onchange="addSub()" name="add_sub" id="add_sub" class="form-control" >
                                            <option value="{{ $data->add_sub }}" selected=""> @if ($data->add_sub == 1) Addition @elseif($data->add_sub == 2)  Substraction @else Select
                                            @endif</option>
                                            <option value="1">Addition</option>
                                            <option value="2">Substraction</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="adjust_bill">Extra Add/Sub<span class="text-red">*</span></label>
                                        <input type="number" oninput="calculation()" name="adjust_bill" id="adjust_bill" value="{{ $data->adjust_bill }}" class="form-control @error('adjust_bill') is-invalid @enderror" placeholder="Enter add/sub bill">

                                        @error('adjust_bill')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="total_amount">Total Amount<span class="text-red">*</span></label>
                                        <input type="hidden" id="sub_total_amount" value="{{ $data->total_amount }}">
                                        <input type="number" name="total_amount" id="total_amount" value="{{ $data->total_amount }}" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-30">
                                <div class="col-sm-12">
                                    <button title="Update Button" type="submit" class="btn btn-success mr-2">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
    @push('js')

    <script>
            if($('#status').val() == 1){
                $('#account_id').append('<option value="">Select Account</option>@foreach ($accounts as $key=> $account)<option value="{{ $account->id }}" @if( $account->id == $data->account_id) selected @endif >{{ $account->name }}</option>@endforeach');
            }else{
                $('#account_id').append("<option value=''>Select Account</option>");
            }

            $('#status').on('change', function() {
                if($('#status').val() == 1){
                    $('#account_id').append('@foreach ($accounts as $key=> $account)<option value="{{ $account->id }}" @if( $account->id == $data->account_id) selected @endif >{{ $account->name }}</option>@endforeach');
                }else{
                    $('#account_id').empty();
                    $('#account_id').append("<option value=''>Select Account</option>");
                }
            })

          function calculation(){
            var add_sub = $('#add_sub').val();
            var adjust_bill = $('#adjust_bill').val();

            if(add_sub == 1){
                var total = $('#sub_total_amount').val();
                var sum =  parseFloat(total)  + parseFloat(adjust_bill) ;
                $('#total_amount').val(sum.toFixed(2));
             }else if(add_sub == 2){
                var adjust_bill = $('#adjust_bill').val();
                var total = $('#sub_total_amount').val();
                var sum =  parseFloat(total) - parseFloat(adjust_bill) ;
                $('#total_amount').val(sum.toFixed(2));
            }
        };

          function addSub(){
            var add_sub = $('#add_sub').val();

            if(add_sub == 1){
                var adjust_bill = $('#adjust_bill').val();
                var total = $('#sub_total_amount').val();
                var sum =  parseFloat(total)  + parseFloat(adjust_bill) ;
                $('#total_amount').val(sum.toFixed(2));
             } else if(add_sub == 2){
                var adjust_bill = $('#adjust_bill').val();
                var total = $('#sub_total_amount').val();
                var sum =  parseFloat(total) - parseFloat(adjust_bill) ;
                $('#total_amount').val(sum.toFixed(2));
            }
        }
    </script>
    @endpush
</x-app-layout>

