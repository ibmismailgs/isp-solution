<x-app-layout>
    @push('css')
         <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    @endpush

    @section('title', 'Create Deposit/Withdraw')

    <x-slot name="header">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="fas fa-compass"></i>
                </div>
                <div>
                    <h4>Create Deposit/Withdraw</h4>
                </div>
            </div>
            <div class="page-title-actions">
                <a href="{{ route('admin.transactions.index') }}" type="button" class="btn btn-sm btn-dark">
                    <i class="fas fa-arrow-left mr-1"></i>
                    Back
                </a>
            </div>
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
                <div class="row">
                    <div class="col-md-12">
                        <form action="{{ route('admin.transactions.store') }}" method="POST">
                            @csrf
                            <div class="row">

                                <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="status"> Account <span class="text-red">*</span></label>
                                        <select name="account_id" id="account_id" class="form-control">
                                            <option value="">Select Account</option>
                                            @foreach ($accounts as $key=> $account)
                                            <option value="{{ $account->id }}">{{ $account->name }}</option>
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
                                        <label for="transaction_amount">Amount <span class="text-red">*</span></label>
                                        <input type="number" name="transaction_amount" id="name" value="{{ old('transaction_amount') }}" class="form-control @error('transaction_amount') is-invalid @enderror" placeholder="Enter transaction amount" required>

                                        @error('transaction_amount')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                  <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="transaction_date"> Date <span class="text-red">*</span></label>
                                        <input type="text" name="transaction_date" id="transaction_date" value="{{ old('transaction_date') }}" class="form-control datepicker @error('transaction_date') is-invalid @enderror" placeholder="Enter transaction date" required>

                                        @error('transaction_date')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-4">

                                    <div class="form-group">
                                        <label for="purpose">Purpose<span class="text-red">*</span></label>
                                        <select name="purpose" id="purpose" class="form-control @error('purpose') is-invalid @enderror">
                                            <option value=""> Select </option>
                                            <option value="1" @if( old('purpose') == 1 )
                                            selected
                                                @endif> Expense </option>
                                            <option value="2" @if( old('purpose') == 2 )
                                            selected
                                                @endif> Given Payment </option>
                                            <option value="3" @if( old('purpose') == 3 )
                                            selected
                                                @endif> Received Payment </option>
                                            <option value="4" @if( old('purpose') == 4 )
                                            selected
                                                @endif>  Deposit</option>
                                        </select>
                                        <div class="help-block with-errors"></div>

                                        @error('purpose')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="payment_type"> Payment Method <span class="text-red">*</span></label>
                                        <select name="payment_type" id="payment_type" class="form-control">
                                            <option value=""> Select</option>
                                            <option value="1"@if( old('payment_type') == 1 )
                                            selected @endif> Cash </option>
                                            <option value="2" @if (old('payment_type') == "2") selected @endif> Cheque </option>
                                        </select>

                                         @error('payment_type')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                 <div class="col-sm-4" id="cheque_number">
                                    <div class="form-group">
                                        <label for="cheque_number"> Cheque Number<span class="text-red">*</span></label>

                                         <input type="text" name="cheque_number" class="form-control @error('cheque_number') is-invalid @enderror" placeholder="Enter check no">

                                         @error('cheque_number')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                 <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="status"> Status <span class="text-red">*</span></label>
                                        <select name="status" id="status" class="form-control">
                                            <option value="1" @if (old('status') == "1") {{ 'selected' }} @endif> Active </option>
                                            <option value="0" @if (old('status') == "0") {{ 'selected' }} @endif> Inactive </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="description"> Description </label>
                                        <textarea style="height: 38px;" name="description" id="description" class="form-control" placeholder="Describe here..."> {!! old('description') !!}</textarea>
                                    </div>
                                </div>

                            </div>

                            <div class="row mt-30">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-success mr-2">Create</button>
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

    <script>


       // date picker
        $('.datepicker').datepicker({
            dateFormat: 'dd MM yy'
        });

        //check field show and hide

        $("#cheque_number").hide();

        $('#payment_type').on('change', function() {
            if($(this).val() == 2){
                $("#cheque_number").show(500);
            }else{
                $("#cheque_number").hide(500);
            }
        });
    </script>

    @endpush
</x-app-layout>
