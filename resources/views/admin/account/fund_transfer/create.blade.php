<x-app-layout>
    @push('css')
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    @endpush
    @section('title', 'Create Fund-Transfer')
    <x-slot name="header">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="fas fa-compass"></i>
                </div>
                <div>
                    <h4>Create Fund-Transfer</h4>
                </div>
            </div>
            <div class="page-title-actions">
                <a title="Back Button" href="{{ route('admin.fund-transfer.index') }}" type="button" class="btn btn-sm btn-dark">
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
                        <form action="{{ route('admin.fund-transfer.store') }}" method="POST">
                            @csrf
                            <div class="row">

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="date"> Date <span class="text-red">*</span></label>

                                        <input type="text" name="date" id="date" value="{{ old('date') }}"
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
                                        <label for="from_account_id"> From Account <span class="text-red">* <span
                                                    class="text-info" id="balance"
                                                    style="display: none"></span></label>
                                        <input type="hidden" value="" id="amount_balance">

                                        <select name="from_account_id" id="from_account_id" onchange="getBalance()"
                                            class="form-control" @error('from_account_id') is-invalid @enderror>
                                            <option value="">Select Account</option>
                                            @foreach ($accounts as $key => $item)
                                                <option value="{{ $item->id }}"> {{ $item->name }} </option>
                                            @endforeach
                                        </select>

                                        @error('from_account_id')
                                            <span class="text-danger" role="alert">
                                                <p>{{ $message }}</p>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="to_account_id"> To Account <span class="text-red">*<span
                                                    class="text-info" id="to_balance"
                                                    style="display: none"></span></span></label>
                                        <input type="hidden" value="" id="to_amount_balance">
                                        <select name="to_account_id" onchange="TogetBalance()"id="to_account_id"
                                            class="form-control" @error('to_account_id') is-invalid @enderror>
                                            <option value="">Select Account</option>
                                            @foreach ($accounts as $key => $item)
                                                <option value="{{ $item->id }}"> {{ $item->name }} </option>
                                            @endforeach
                                        </select>

                                        @error('to_account_id')
                                            <span class="text-danger" role="alert">
                                                <p>{{ $message }}</p>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="amount"> Amount <span class="text-red">*</span></label>

                                        <input type="number" name="amount" onkeyup="AmountCheck()"
                                        id="amount"
                                            value="{{ old('amount') }}"
                                            class="form-control @error('amount') is-invalid @enderror"
                                            placeholder="Enter amount" required>

                                        @error('amount')
                                            <span class="text-danger" role="alert">
                                                <p>{{ $message }}</p>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="description"> Description </label>
                                        <textarea name="description" rows="3" id="description" class="form-control" placeholder="Describe here..."> {!! old('description') !!}</textarea>
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
            $(function() {
                $('.datepicker').datepicker({
                    dateFormat: 'dd MM yy',
                });
            });

            function getBalance() {
                var accountId = $('#from_account_id').val();
                if (accountId !== null) {
                    var url = '{{ route('admin.account-balance', ':id') }}';
                    $.ajax({
                        type: "GET",
                        url: url.replace(':id', accountId),
                        success: function(resp) {
                            $('#balance').show();
                            document.getElementById('balance').innerHTML = '( ' + resp + ' )';
                            $('#amount_balance').val(resp);
                        },
                    })
                }
            }

            function TogetBalance() {
                var accountId = $('#to_account_id').val();
                if (accountId !== null) {
                    var url = '{{ route('admin.account-balance', ':id') }}';
                    $.ajax({
                        type: "GET",
                        url: url.replace(':id', accountId),
                        success: function(resp) {
                            $('#to_balance').show();
                            document.getElementById('to_balance').innerHTML = '( ' + resp + ' )';
                            $('#to_amount_balance').val(resp);
                        },
                    })
                }
            }

            function AmountCheck() {
                if ($('#from_account_id').val() &&$('#to_account_id').val() ) {
                var amount = $('#amount').val();
                var amountBalance = $('#amount_balance').val();
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
            else{
                alert("select bank account first");
              }
            };
        </script>
    @endpush
</x-app-layout>
