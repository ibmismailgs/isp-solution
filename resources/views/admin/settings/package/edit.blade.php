<x-app-layout>

    @section('title', 'Edit Package')
    <x-slot name="header">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="fas fa-compass"></i>
                </div>
                <div>
                    <h4>Edit Package</h4>
                </div>
            </div>
            <div class="page-title-actions">
                <a title="Back Button" href="{{ route('admin.package.index') }}" type="button" class="btn btn-sm btn-dark">
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
                        <form action="{{ route('admin.package.update', $package->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">

                                  <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="connection_type_id "> Connetion Type <span class="text-red">*</span></label>

                                    <select id="connection_type_id" name="connection_type_id" class="form-control @error('connection_type_id') is-invalid @enderror" >

                                        <option value=""> Select Connection </option>
                                        @foreach($connections as $connection)
                                        <option value="{{$connection->id}}" {{ $connection->id == $package->connection_type_id ? 'selected' : ' '}}>
                                            {{$connection->name}}
                                        </option>
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
                                        <input type="text" name="name" id="name" value="{{ $package->name }}" class="form-control @error('name') is-invalid @enderror" placeholder="Please enter a package name" required>

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
                                        <input type="text" name="code" id="code" value="{{ $package->code }}" class="form-control @error('code') is-invalid @enderror" placeholder="Please enter a package code" required>

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

                                        <input type="text" name="package_spreed" id="package_spreed" value="{{ $package->package_spreed }}" class="form-control @error('package_spreed') is-invalid @enderror" placeholder="Please enter package spreed" required>

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
                                        <input type="number" min="0" name="amount" id="amount" value="{{ $package->amount }}" class="form-control @error('name') is-invalid @enderror" placeholder="Please enter package amount" required>

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
                                            <option value="1" {{ $package->status == 1 ? 'selected' : '' }}>Active</option>
                                            <option value="0" {{ $package->status == 0 ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="description"> Description <span class="text-red">*</span></label>
                                        <textarea name="description"
                                        rows="3" id="description" class="form-control @error('description') is-invalid @enderror" placeholder="Describe here...">{{ $package->description }}</textarea>
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
    <script type="text/javascript">
         $(document).ready(function(){
            $('#code_generate').click(function(e){
               e.preventDefault();
               $.ajax({

                  url: "{{ route('admin.package-code') }}",
                  method: 'GET',
                  success: function(result){
                      $('#code').val('WTL - '+ result)
                  }});
               });
            });
    </script>
    @endpush
</x-app-layout>
