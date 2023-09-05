<x-app-layout>

    @push('css')
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    @endpush
    @section('title', 'Client Bill Pay Request')
    <x-slot name="header">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="fas fa-compass"></i>
                </div>
                <div>
                    <h4>Client Bill Pay Request</h4>
                </div>
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

       @if(empty($client_billing_data))
            <div class="page-header">
            <div class="d-inline">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        You don't have any due
                        <button title="Close Button" type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
            </div>
        </div>
       @else
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <form action="{{ route('admin.client-bill-store') }}" method="POST">
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
                                        <input type="hidden" name="subscriber_id" id="subscriber_id" value="{{ isset($user->subscriber_id) ? $user->subscriber_id : null}}">

                                        <input type="hidden" name="billpay_id" id="billpay_id" value="{{ isset($client_billing_data->id) ?  $client_billing_data->id : null}}">

                                        <input type="text" value="{{ $user->subscribers->subscriber_id }}" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Enter name" readonly>

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
                                        <input type="text" name="name" id="name" value="{{ $user->name }}" class="form-control @error('name') is-invalid @enderror" placeholder="Enter name" readonly>

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
                                        <input type="text" name="billing_month" value="{{ isset($client_billing_data->billing_month) ? $client_billing_data->billing_month : null }}" class="form-control" id="billing_month" placeholder="Enter month" readonly>

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
                                        <input type="text" name="amount" id="amount"
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
        @endif

    </div>
    @push('js')
        <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script>
            $('.datepicker').datepicker({
                dateFormat: 'dd MM yy'
            });
        </script>
    @endpush
</x-app-layout>
