<x-app-layout>
    @push('css')
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    @endpush
    @section('title', 'Bill Pay')

    <x-slot name="header">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="fas fa-compass"></i>
                </div>
                <div>
                    <h4>Bill Pay</h4>
                </div>
            </div>
            <div class="page-title-actions">
                <a title="Back Button" href="{{ route('admin.bill-pay.index') }}" type="button" class="btn btn-sm btn-dark">
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
                        {{ Session::get('error') }}
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
                        <form action="{{ route('admin.bill-pay.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="date"> Date <span class="text-red">*</span></label>
                                        <input type="text" name="date" id="date"
                                            value="{{ old('date') }}"
                                            class="form-control datepicker @error('date') is-invalid @enderror"
                                            placeholder="Enter date" required>

                                        @error('date')
                                            <span class="text-danger" role="alert">
                                                <p>{{ $message }}</p>
                                            </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="subscriber_id"> Client ID <span class="text-red">*</span></label>
                                        <input type="hidden" name="subscriber_id" id="subscriber_id">

                                        <select name="client_id" id="client_id" class="form-control client_id">
                                            <option value="">--Select Client ID--</option>
                                            @foreach ($client as $item)
                                            <option value="{{ $item->id }}">{{  $item->subscribers->subscriber_id }}
                                            </option>
                                            @endforeach
                                        </select>

                                        @error('client_id')
                                            <span class="text-danger" role="alert">
                                                <p>{{ $message }}</p>
                                            </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="name"> Name <span class="text-red">*</span></label>
                                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Enter name" readonly>

                                        @error('name')
                                            <span class="text-danger" role="alert">
                                                <p>{{ $message }}</p>
                                            </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="billing_month"> Billing Month<span class="text-red">*</span></label>
                                        <input type="text" name="billing_month" class="form-control" id="billing_month" placeholder="Enter month" readonly>

                                        @error('billing_month')
                                            <span class="text-danger" role="alert">
                                                <p>{{ $message }}</p>
                                            </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="amount"> Amount <span class="text-red">*</span>
                                            </span></label>
                                        <input type="hidden" value="" id="amount_balance">
                                        <input type="text" name="amount" id="amount"
                                            onkeyup="checkAmount(this)"
                                            value="{{ $client_billing_data->total_amount ?? '' }}"
                                            class="form-control @error('amount') is-invalid @enderror"
                                            placeholder=" Enter amount" readonly>

                                        @error('amount')
                                            <span class="text-danger" role="alert">
                                                <p>{{ $message }}</p>
                                            </span>
                                        @enderror

                                    </div>
                                </div>


                                <div class="col-sm-6 bank-way" >
                                    <label for="account_id">Bank Account<span class="text-danger">*</span>
                                        <span class="text-info" id="balance" style="display: none"></span>
                                        </label>
                                    <div
                                        class="form-group{{ $errors->has('account_id') ? ' has-error' : '' }} has-feedback">
                                        <select name="account_id" id="account_id" class="form-control"
                                            onchange="getBalance()"> >
                                            <option value="" selected>-- Select Bank Account --</option>
                                            @foreach ($accounts as $bankAccount)
                                                <option value="{{ $bankAccount->id }}">{{ $bankAccount->name }}
                                                    | {{ $bankAccount->account_no }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('account_id'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('account_id') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-30">
                                <div class="col-sm-12">
                                    <button title="Submit Button" type="submit" class="btn btn-success mr-2">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
    @push('js')
        <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script>
            $('.datepicker').datepicker({
                dateFormat: 'dd MM yy'
            });

         $('#client_id').on('change',function(){
                var client_id = $("#client_id").val();
                var name = $("#name").val();
                var billing_month = $("#billing_month").val();
                var amount = $("#amount").val();
                 var url = "{{route('admin.subscriber-data')}}";
                    $.ajax({
                        type: "get",
                        url: url,
                        data: {
                            id: client_id
                        },
                        success: function(data) {
                            $("#subscriber_id").val(data.subscriber.id);
                            $("#name").val(data.subscriber.name);
                            $("#billing_month").val(data.client_billing_data.billing_month);
                            $("#amount").val(data.client_billing_data.total_amount);
                        }
                    });
            });
        </script>
    @endpush
</x-app-layout>
