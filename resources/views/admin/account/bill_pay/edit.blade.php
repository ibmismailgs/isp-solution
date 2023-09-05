<x-app-layout>

    @push('css')
         <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    @endpush

    @section('title', 'Edit Bill Pay')

    <x-slot name="header">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="fas fa-compass"></i>
                </div>
                <div>
                    <h4>Edit Bill Pay</h4>
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
                        <form action="{{ route('admin.bill-pay.update', $data->id) }}" method="POST">
                           @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="subscriber_id"> Client ID <span class="text-red">*</span></label>
                                        <input type="hidden" value="{{ $data->client_id }}" name="client_id">
                                        <input type="text" name="subscriber_id" id="subscriber_id" value="{{ $data->subscriber_id }}" class="form-control @error('subscriber_id') is-invalid @enderror" readonly>

                                        @error('subscriber_id')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="name"> Name <span class="text-red">*</span></label>
                                        <input type="text" name="name" id="name" value="{{ $data->name ?? '' }}" class="form-control @error('name') is-invalid @enderror" placeholder="Enter name" readonly>

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
                                        <input type="text" name="billing_month" id="billing_month" value="{{ $data->billing_month }}" class="form-control @error('billing_month') is-invalid @enderror" placeholder="Enter month" readonly>

                                        @error('billing_month')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="amount"> Amount <span class="text-red">*</span></label>
                                        <input type="text" name="amount" id="amount" value="{{ $data->amount }}" class="form-control @error('amount') is-invalid @enderror" placeholder=" Enter amount" readonly>

                                        @error('amount')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="mobile"> Phone <span class="text-red">*</span></label>
                                        <input type="text" name="mobile" id="mobile" value="{{ $data->mobile }}" class="form-control @error('mobile') is-invalid @enderror" placeholder="Enter phone number" required>

                                        @error('mobile')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="date"> Date <span class="text-red">*</span></label>
                                        <input type="text" name="date" id="date" value="{{ Carbon\Carbon::parse($data->date)->format('d F Y') }}" class="form-control datepicker @error('date') is-invalid @enderror" placeholder="Enter date" required>

                                        @error('date')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

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
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>

    <script>
        $('.datepicker').datepicker({
            dateFormat: 'dd MM yy'
        });
    </script>

    @endpush
</x-app-layout>
