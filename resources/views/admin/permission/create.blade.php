<x-app-layout>

    @section('title', 'Create Permission')
    @push('css')
        <link rel="stylesheet" href="{{ asset('select2/dist/css/select2.min.css') }}">
    @endpush

    <x-slot name="header">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="fas fa-compass"></i>
                </div>
                <div>
                    <h4>Create Permission</h4>
                </div>
            </div>
            <div class="page-title-actions">
                <a title="Back Button" href="{{ route('admin.permission.index') }}" type="button" class="btn btn-sm btn-dark">
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
                        <form class="forms-sample" method="POST" action="{{ route('admin.permission.store') }}">
                            @csrf
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="permission">{{ __('Permission')}}<span class="text-red">*</span></label>
                                        <input type="text" class="form-control" id="permission" name="permission" placeholder="Permission Name" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail3">{{ __('Assigned to Role')}} </label>
                                        {!! Form::select('roles[]', $roles, null,[ 'class'=>'form-control select2', 'multiple' => 'multiple']) !!}
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <button title="Save Button" type="submit" class="btn btn-primary btn-rounded">{{ __('Save')}}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
    @push('js')
     <script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
    @endpush
</x-app-layout>
