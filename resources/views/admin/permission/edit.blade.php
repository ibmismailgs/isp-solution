<x-app-layout>
    @section('title', 'Edit Permission')
    @push('css')
        <link rel="stylesheet"  type="text/css" href="{{ asset('select2/dist/css/select2.min.css') }}">
    @endpush

    <x-slot name="header">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="fas fa-compass"></i>
                </div>
                <div>
                    <h4>Edit Permission</h4>
                </div>
            </div>
            <div class="page-title-actions">
                @can('create')
                    <a title="Create Button" href="{{ route('admin.permission.create') }}" type="button" class="btn btn-sm btn-info">
                        <i class="fas fa-plus mr-1"></i>
                        Create
                    </a>
                @endcan
            </div>
        </div>
    </x-slot>

    <div class="container-fluid">
    	<div class="page-header">
            <div class="d-inline">
                @if (Session::has('message'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{Session::get('message')}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

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
    </div>

    <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <form action="{{ route('admin.permission.update', $permission->id) }}" method="POST">
                            @method('PUT')
                            @csrf
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="name">Permission<span class="text-red">*</span></label>
                                        <input type="text" name="name" id="name" value="{{ $permission->name }}" class="form-control @error('name') is-invalid @enderror" placeholder="permission name" required>

                                        @error('name')
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
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('app-assets/vendors/js/extensions/toastr.min.js') }}"></script>
    <script src="{{ asset('select2/dist/js/select2.min.js') }}"></script>
    <script>
        $('select').select2();
    </script>

    @endpush
</x-app-layout>
