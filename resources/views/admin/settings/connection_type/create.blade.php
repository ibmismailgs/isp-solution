<x-app-layout>

    @section('title', 'Create Connection')

    <x-slot name="header">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="fas fa-compass"></i>
                </div>
                <div>
                    <h4>Create Connection</h4>
                </div>
            </div>
            <div class="page-title-actions">
                <a href="{{ route('admin.connection.index') }}" type="button" class="btn btn-sm btn-dark">
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
                        <form action="{{ route('admin.connection.store') }}" method="POST">
                            @csrf
                            <div class="row">

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="name">Connection Name<span class="text-red">*</span></label>
                                        <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" placeholder="Please enter an connection name" required>
                                        @error('name')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="code">Connection Code<span class="text-red">*</span></label>
                                        <div class="input-group">
                                        <input type="text" name="code" id="code" value="{{ old('code') }}" class="form-control @error('code') is-invalid @enderror" placeholder="Please enter an connection code" required>
                                        <button class="input-group-addon btn-info" id="code_generate" >Generate Code</button>
                                        </div>

                                        @error('code')
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
                                            <option value="1" @if (old('status') == "1") {{ 'selected' }} @endif>Active</option>
                                            <option value="0" @if (old('status') == "0") {{ 'selected' }} @endif>Inactive</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="description"> Description </label>
                                        <textarea name="description" id="description" class="form-control" placeholder="Describe here...">{!! old('description') !!}</textarea>
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
    {{-- automatic code generate --}}
    <script type="text/javascript">
         $(document).ready(function(){

            $('#code_generate').click(function(e){
               e.preventDefault();
               $.ajax({

                  url: "{{ route('admin.connection-code') }}",
                  method: 'GET',
                  success: function(result){
                      $('#code').val('WTL - '+ result);
                  }});
               });
            });
    </script>
    @endpush
</x-app-layout>
