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
                <a title="Back Button" href="{{ route('admin.transactions.index') }}" type="button" class="btn btn-sm btn-dark">
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
                @if (Session::has('message'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
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
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <form action="{{ route('admin.transactions.store') }}" method="POST">
                            @csrf
                            <div class="row">

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="transaction_date"> Date <span class="text-red">*</span></label>
                                        <input type="text" name="transaction_date" id="transaction_date"
                                            value="{{ old('transaction_date') }}"
                                            class="form-control datepicker @error('transaction_date') is-invalid @enderror"
                                            placeholder="Enter transaction date" required>

                                        @error('transaction_date')
                                            <span class="text-danger" role="alert">
                                                <p>{{ $message }}</p>
                                            </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="status"> Account <span class="text-red">*</span><span
                                                class="text-info" id="balance" style="display: none">
                                            </span></label>
                                        <input type="hidden" value="" id="amount_balance">
                                        <select name="account_id" id="account_id" class="form-control"
                                            onchange="getBalance()">
                                            <option value="">Select Account</option>
                                            @foreach ($accounts as $key => $account)
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
                                        <label for="transaction_type">Purpose<span class="text-red">*</span></label>
                                        <select name="transaction_type" id="transaction_type"
                                            class="form-control @error('transaction_type') is-invalid @enderror">
                                            <option value=""> ---Select--- </option>
                                            <option value="1" @if (old('transaction_type') == 1) selected @endif>
                                                Withdraw </option>
                                            <option value="2" @if (old('transaction_type') == 2) selected @endif>
                                                Deposit</option>
                                        </select>
                                        <div class="help-block with-errors"></div>

                                        @error('transaction_type')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="transaction_amount">Amount <span class="text-red">*</span></label>
                                        <input type="number" oninput="CheckAmount(this)"name="transaction_amount"
                                            id="amount" value="{{ old('transaction_amount') }}"
                                            class="form-control @error('transaction_amount') is-invalid @enderror"
                                            placeholder="Enter transaction amount" required>

                                        @error('transaction_amount')
                                            <span class="text-danger" role="alert">
                                                <p>{{ $message }}</p>
                                            </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="payment_type"> Payment Method <span
                                                class="text-red">*</span></label>
                                        <select name="payment_type" id="payment_type" class="form-control">
                                            <option value=""> Select</option>
                                            <option value="1"@if (old('payment_type') == 1) selected @endif>
                                                Cash </option>
                                            <option value="2" @if (old('payment_type') == '2') selected @endif>
                                                Cheque </option>
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
                                        <label for="cheque_number"> Cheque Number<span
                                                class="text-red">*</span></label>

                                        <input type="text" name="cheque_number"
                                            class="form-control @error('cheque_number') is-invalid @enderror"
                                            placeholder="Enter check no">

                                        @error('cheque_number')
                                            <span class="text-danger" role="alert">
                                                <p>{{ $message }}</p>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="description"> Description </label>
                                        <textarea rows="3" name="description" id="description" class="form-control" placeholder="Describe here..."> {!! old('description') !!}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-30">
                                <div class="col-sm-12">
                                    <button title="Create Button" type="submit" class="btn btn-success mr-2">Create</button>
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
            // date picker
            $('.datepicker').datepicker({
                dateFormat: 'dd MM yy'
            });

            //check field show and hide
            $("#cheque_number").hide();
            $('#payment_type').on('change', function() {
                if ($(this).val() == 2) {
                    $("#cheque_number").show(500);
                } else {
                    $("#cheque_number").hide(500);
                }
            });
            //
            function getBalance() {
                var accountId = $('#account_id').val();
                if (accountId !== null) {
                    var url = '{{ route('admin.account-balance', ':id') }}';
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
            function CheckAmount(amount) {
                if ($('#account_id').val()) {
                    if ($('#transaction_type').val()) {
                        var amount = amount.value;
                        var amountBalance = $('#amount_balance').val();
                        if ($('#transaction_type').val() == 1) {
                            if (parseFloat(amountBalance) < parseFloat(amount)) {
                                swal({
                                    title: `Alert?`,
                                    text: "You don't have enough balance.",
                                    buttons: true,
                                    dangerMode: true,
                                }).then((willDelete) => {
                                    if (willDelete) {
                                        $('#amount').val(0);

                                    }
                                });

                            }
                        }
                    } else {
                        $('#amount').val(0);
                        alert('please select Purpose*')
                    }
                } else {
                    $('#amount').val(0);
                    alert('please select Bank Account first')
                }
            }
        </script>
    @endpush
</x-app-layout>
