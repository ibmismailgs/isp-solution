<x-app-layout>

    @section('title', 'Create Package')

    <x-slot name="header">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="fas fa-compass"></i>
                </div>
                <div>
                    <h4>Create Packages</h4>
                </div>
            </div>
            <div class="page-title-actions">
                <a href="{{ route('admin.package.index') }}" type="button" class="btn btn-sm btn-dark">
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
                        <form action="{{ route('admin.package.store') }}" method="POST">
                            @csrf
                            <div class="row">

                                  <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="connection_type_id "> Connetion Type <span class="text-red">*</span></label>

                                        <select id="connection_type_id" name="connection_type_id" class="form-control @error('connection_type_id') is-invalid @enderror" required="">

                                            <option value="">Select Connection</option>
                                            @foreach($connections as $connection)
                                                <option value="{{$connection->id}}">{{$connection->name}}</option>
                                            @endforeach
                                        </select>

                                         @error('connection_type_id')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="name">Package Name<span class="text-red">*</span></label>
                                        <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" placeholder="Please enter a package name" required>

                                        @error('name')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="code">Package Code<span class="text-red">*</span></label>

                                        <div class="input-group">
                                        <input type="text" name="code" id="code" value="{{ old('code') }}" class="form-control @error('code') is-invalid @enderror" placeholder="Please enter a package code" required>

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
                                        <label for="package_spreed">Package Spreed<span class="text-red">*</span></label>

                                        <input type="text" name="package_spreed" id="package_spreed" value="{{ old('package_spreed') }}" class="form-control @error('package_spreed') is-invalid @enderror" placeholder="Please enter package spreed" required>

                                        @error('package_spreed')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                 <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="amount">Amount<span class="text-red">*</span></label>
                                        <input type="number" min="0" name="amount" id="amount" value="{{ old('amount') }}" class="form-control @error('name') is-invalid @enderror" placeholder="Please enter package amount" required>

                                        @error('amount')
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
                                        <textarea class="form-control h-10" name="description" id="description" class="form-control" placeholder="Describe here...">{!! old('description') !!}</textarea>
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
    <script type="text/javascript">
         $(document).ready(function(){

            $('#code_generate').click(function(e){
               e.preventDefault();
               $.ajax({

                  url: "{{ route('admin.package-code') }}",
                  method: 'GET',
                  success: function(result){
                      $('#code').val('WTL - '+ result);
                  }});
               });
            });
    </script>
    @endpush
</x-app-layout>
