<x-app-layout>
    @section('title', 'Create Complaint')
    <x-slot name="header">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="fas fa-compass"></i>
                </div>
                <div>
                    <h4>Create Complaint</h4>
                </div>
            </div>
            <div class="page-title-actions">
                <a title="Back Button" href="{{ route('admin.complaint.index') }}" type="button" class="btn btn-sm btn-dark">
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
                        <form action="{{ route('admin.complaint.store') }}" method="POST">
                            @csrf
                            <div class="row">

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="ticket_id">Ticket ID<span class="text-red">*</span></label>
                                        <input type="text" name="ticket_id" id="ticket_id"
                                            value="{{ $cid + 1 }}" class="form-control" readonly>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="classification_id "> Ticket Type<span
                                                class="text-red">*</span></label>

                                        <select id="classification_id" name="classification_id"
                                            class="form-control @error('classification_id') is-invalid @enderror"
                                            required="">

                                            <option value="">Select Connection</option>
                                            @foreach ($classifications as $classification)
                                                <option value="{{ $classification->id }}">{{ $classification->name }}
                                                </option>
                                            @endforeach
                                        </select>

                                        @error('classification_id')
                                            <span class="text-danger" role="alert">
                                                <p>{{ $message }}</p>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="name">Name<span class="text-red">*</span></label>
                                        <input type="text" name="name" id="name" value="{{ $user->name }}"
                                            class="form-control @error('name') is-invalid @enderror"
                                            placeholder="Enter a name" readonly>

                                            <input type="hidden" name="subscriber_id" value="{{ $user->subscriber_id }}">

                                        @error('name')
                                            <span class="text-danger" role="alert">
                                                <p>{{ $message }}</p>
                                            </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="contact_no">Contact<span class="text-red">*</span></label>
                                        <input type="text" name="contact_no" id="contact_no"
                                            value="{{ $user->subscribers->contact_no ?? '' }}"
                                            class="form-control @error('contact_no') is-invalid @enderror"
                                            placeholder="Enter your contact number" readonly>

                                        @error('contact_no')
                                            <span class="text-danger" role="alert">
                                                <p>{{ $message }}</p>
                                            </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="email">Email<span class="text-red">*</span></label>
                                        <input type="email" name="email" id="email" value="{{ $user->email }}"
                                            class="form-control @error('name') is-invalid @enderror"
                                            placeholder="Enter your email" readonly>

                                        @error('email')
                                            <span class="text-danger" role="alert">
                                                <p>{{ $message }}</p>
                                            </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="piority"> Piority <span class="text-red">*</span></label>
                                        <select name="piority" id="piority" class="form-control">
                                            <option value="1"
                                                @if (old('piority') == '1') {{ 'selected' }} @endif>High
                                            </option>
                                            <option value="0"
                                                @if (old('piority') == '0') {{ 'selected' }} @endif>Low
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                        <div class="row">
                            <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="address">Address<span class="text-red">*</span></label>
                                        <textarea rows="3" name="address" id="address" class="form-control" placeholder="Write your address">{!! old('address') !!}</textarea>

                                        @error('address')
                                            <span class="text-danger" role="alert">
                                                <p>{{ $message }}</p>
                                            </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="description"> Description </label>
                                        <textarea class="form-control" rows="3" name="description"  class="form-control"
                                            placeholder="Describe here...">{!! old('description') !!}</textarea>
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
</x-app-layout>
