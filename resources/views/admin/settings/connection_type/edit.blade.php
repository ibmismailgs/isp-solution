<x-app-layout>

    @section('title', 'Edit Connection')

    <x-slot name="header">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="fas fa-compass"></i>
                </div>
                <div>
                    <h4>Edit Connection</h4>
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
                        <form action="{{ route('admin.connection.update', $data->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="name">Connection Name<span class="text-red">*</span></label>
                                        <input type="text" name="name" id="name" value="{{ $data->name }}" class="form-control @error('name') is-invalid @enderror" placeholder="Please enter an connection name" required>

                                        <div class="help-block with-errors"></div>

                                        @error('name')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="code">Connection Code<span class="text-red">*</span></label>
                                        <div class="input-group">
                                            <input type="text" name="code" id="code" value="{{ $data->code }}" class="form-control @error('code') is-invalid @enderror" placeholder="Please enter an connection code" required>
                                            <button class="input-group-addon btn-info" id="code_generate" >Generate Code</button>
                                        </div>

                                        @error('code')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="status"> Status <span class="text-red">*</span></label>
                                        <select name="status" id="status" class="form-control">
                                            <option value="{{ $data->status }}" selected=""> @if ($data->status == 1) Active @else Inactive
                                            @endif</option>
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>

                                        <div class="help-block with-errors"></div>

                                        @error('status')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="description"> Description <span class="text-red">*</span></label>
                                        <textarea name="description" id="description" cols="2" rows="2" class="form-control @error('description') is-invalid @enderror" placeholder="Describe here...">{{ $data->description }}</textarea>
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
