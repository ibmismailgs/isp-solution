<x-app-layout>

    @section('title', 'Edit Account')

    <x-slot name="header">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="fas fa-compass"></i>
                </div>
                <div>
                    <h4>Edit Account</h4>
                </div>
            </div>
            <div class="page-title-actions">
                <a href="{{ route('admin.account.index') }}" type="button" class="btn btn-sm btn-dark">
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
                        <form action="{{ route('admin.account.update', $data->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="account_type_id"> Account Type <span class="text-red">*</span></label>

                                        <select name="account_type_id" id="account_type_id" class="form-control">
                                            <option value="">Select Account Type</option>
                                            @foreach ($account_types as $key => $item)
                                                <option value="{{ $item->id }}" @if($item->id == $data->account_type_id) @endif selected> {{ $item->name }} </option>
                                            @endforeach
                                        </select>

                                         @error('account_type_id')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="name">Account Name<span class="text-red">*</span></label>
                                        <input type="text" name="name" id="name" value="{{ old('name', $data->name) }}" class="form-control @error('name') is-invalid @enderror" placeholder="Enter account name" required>

                                        @error('name')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="account_no">Account No<span class="text-red">*</span></label>
                                        <input type="text" name="account_no" id="account_no" value="{{ old('account_no', $data->account_no) }}" class="form-control @error('account_no') is-invalid @enderror" placeholder="Enter account no" required>

                                        @error('account_no')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                 <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="bank_id"> Bank Name <span class="text-red">*</span></label>

                                        <select class="form-control" name="bank_id" id="bank_id">
                                            <option value=""> Select Bank</option>
                                            @foreach ($banks as $key => $item)
                                                <option value="{{ $item->id }}" @if($item->id == $data->bank_id) @endif selected> {{ $item->name }} </option>
                                            @endforeach
                                        </select>

                                         @error('bank_id')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                 <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="branch_name"> Branch Name<span class="text-red">*</span></label>

                                        <input type="text" name="branch_name" id="branch_name" value="{{ old('branch_name', $data->branch_name) }}" class="form-control @error('branch_name') is-invalid @enderror" placeholder="Enter branch name " required>

                                         @error('branch_name')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                 <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="branch_address"> Branch Address<span class="text-red">*</span></label>

                                        <input type="text" name="branch_address" id="branch_address" value="{{ old('branch_address', $data->branch_address ) }}" class="form-control @error('branch_address') is-invalid @enderror" placeholder="Enter branch address " required>

                                         @error('branch_address')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                 <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="initial_balance"> Initial Balance <span class="text-red">*</span></label>

                                        <input type="number" name="initial_balance" id="initial_balance" value="{{ old('initial_balance', $data->initial_balance) }}" class="form-control @error('initial_balance') is-invalid @enderror" placeholder="Enter initial blance" required>

                                         @error('initial_balance')
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
                                            <option value="{{ $data->status }}" selected="">
                                                @if ($data->status == 1)
                                                        Active
                                                    @else
                                                        Inactive
                                                 @endif
                                            </option>
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>

                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="description"> Description </label>
                                        <textarea style="height: 38px;" name="description" id="description" class="form-control" placeholder="Describe here..."> {!! old('description', $data->description) !!}</textarea>
                                    </div>
                                </div>

                            </div>

                            <div class="row mt-30">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-success mr-2">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
    @push('js')

    @endpush
</x-app-layout>
