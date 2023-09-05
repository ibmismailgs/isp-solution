<x-app-layout>
    @section('title', 'Edit Classification')
    <x-slot name="header">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="fas fa-compass"></i>
                </div>
                <div>
                    <h4>Edit Classification</h4>
                </div>
            </div>
            <div class="page-title-actions">
                <a title="Back Button" href="{{ route('admin.classification.index') }}" type="button" class="btn btn-sm btn-dark">
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
                        <form action="{{ route('admin.classification.update', $complaint->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="name">Classification Name<span class="text-red">*</span></label>
                                        <input type="text" name="name" id="name" value="{{ $complaint->name }}" class="form-control @error('name') is-invalid @enderror" placeholder="Please enter an area name" required>

                                        @error('name')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>
                                 <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="status"> Status <span class="text-red">*</span></label>

                                        <select name="status" id="status" class="form-control">
                                            <option value="1" {{ $complaint->status == 1 ? 'selected' : '' }}>Active</option>
                                            <option value="0" {{ $complaint->status == 0 ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="description"> Description <span class="text-red">*</span></label>
                                        <textarea name="description" id="description" cols="2" rows="2" class="form-control @error('description') is-invalid @enderror" placeholder="Describe here...">{{ $complaint->description }}</textarea>
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
</x-app-layout>
