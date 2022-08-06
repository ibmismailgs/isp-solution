<x-app-layout>
    @push('css')
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    @endpush

    @section('title', 'Client Dashboard')

    <x-slot name="header">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="fas fa-compass"></i>
                </div>
                <div>
                    <h4>Client Dashboard</h4>
                </div>
            </div>
            {{-- <div class="page-title-actions">
                <a href="{{ route('admin.complaint.create') }}" type="button" class="btn btn-sm btn-info">
                    <i class="fas fa-plus mr-1"></i>
                    Create
                </a>
            </div> --}}
        </div>
    </x-slot>

    <!-- Main Content -->
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
                        <div class="container">
                            <div class="main-body">
                                <div class="row gutters-sm">
                                    <div class="col-md-4 mb-3">
                                        {{-- <div class="card" style="background-color: #F8F9F9"> --}}
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-flex flex-column align-items-center text-center">
                                                    <img src="{{asset('img/'.$data->image)}}" alt="Profile Picture Missing" class="rounded-circle" width="150">
                                                    <div class="mt-3">
                                                    <h4>{{ $data->name }}</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <div class="card mt-3">
                                        <ul class="list-group list-group-flush">
                                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                            <h6 class="mb-0">Area</h6>
                                            <span class="text-secondary"> <b>{{ $data->areas->name  }}</b></span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                            <h6 class="mb-0">Connection</h6>
                                            <span class="text-secondary"> <b>{{ $data->connections->name  }}</b></span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                            <h6 class="mb-0">Package</h6>
                                            <span class="text-secondary"><b>{{ $data->packages->name }}</b></span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                            <h6 class="mb-0">Amount</h6>
                                            <span class="text-secondary"><b>{{ $data->packages->amount }}</b></span>
                                        </li>
                                        </ul>
                                    </div>
                                    </div>
                                    <div class="col-md-8">
                                    <div class="card mb-3">
                                        <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-3">
                                            <h6 class="mb-0">Client ID Number</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                           {{ $data->subscriber_id }}
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                            <h6 class="mb-0">IP Address</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                           {{ $data->ip_address }}
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                            <h6 class="mb-0">Joining Date</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                           {{ $data->initialize_date }}
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                            <h6 class="mb-0">Email</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                            {{ $data->email }}
                                            </div>
                                        </div>
                                        <hr>
                                        {{-- <div class="row">
                                            <div class="col-sm-3">
                                            <h6 class="mb-0">Phone</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                            (239) 816-9029
                                            </div>
                                        </div>
                                        <hr> --}}
                                        <div class="row">
                                            <div class="col-sm-3">
                                            <h6 class="mb-0">Contact No</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                             {{ $data->contact_no }}
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                            <h6 class="mb-0">Address</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                            {{ $data->address }}
                                            </div>
                                        </div>
                                        {{-- <hr> --}}
                                        {{-- <div class="row">
                                            <div class="col-sm-12">
                                              <a class="btn btn-primary" id="btn-contact"  data-toggle="modal" data-target="#contact">Edit Profile </a>

                                                <a class="btn btn-info" id="btn-contact"  data-toggle="modal" data-target="#contact">Change Area </a>

                                                <a class="btn btn-secondary" id="btn-contact"  data-toggle="modal" data-target="#contact">Change Connection </a>

                                                <a class="btn btn-success" id="btn-contact"  data-toggle="modal" data-target="#contact">Change Package </a>
                                            </div>
                                        </div> --}}
                                        </div>
                                    </div>
                                    <hr>

                                    <a class="btn btn-primary" id="editprofile"  data-toggle="modal" data-target="#EditProfile">Edit Profile </a>

                                    <a class="btn btn-info" id="area"  data-toggle="modal" data-target="#ChangeArea">Change Area </a>

                                    {{-- <a class="btn btn-secondary" id="connection"  data-toggle="modal" data-target="#ChangeConnection">Change Connection </a> --}}

                                    <a class="btn btn-success" id="package"  data-toggle="modal" data-target="#ChangePackage">Change Connection & Package </a>

                                  </div>
                                </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

     {{-- Edit profile Modal form --}}
        <div class="modal fade" id="EditProfile" tabindex="-1" role="dialog" aria-labelledby="EditProfile" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="EditProfile">Edit Profile</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <form enctype="multipart/form-data" action="{{ route('admin.client-dashboard.update', $data->id )}}" method="POST">
                    @csrf
                    @method('PUT')

                <div class="modal-body">
                   <div class="form-group">
                        <label for="name">Client Name<span class="text-red">*</span></label>
                        <input type="text" name="name" id="name" value="{{ $data->name }}" class="form-control @error('name') is-invalid @enderror" placeholder="Enter client name" required>

                        @error('name')
                        <span class="text-danger" role="alert">
                            <p>{{ $message }}</p>
                        </span>
                        @enderror

                    </div>

                    <div class="form-group">
                        <label for="contact_no">Contact No <span class="text-red">*</span></label>
                        <input type="text" name="contact_no" id="contact_no" value="{{ $data->contact_no }}" class="form-control @error('contact_no') is-invalid @enderror" placeholder=" Enter your contact no.." required>

                        @error('contact_no')
                        <span class="text-danger" role="alert">
                            <p>{{ $message }}</p>
                        </span>
                        @enderror
                    </div>

                     <div class="form-group">
                        <label for="email">Email <span class="text-red">*</span></label>
                        <input type="email" name="email" id="email" value="{{ $data->email }}" class="form-control @error('email') is-invalid @enderror" placeholder="Enter your email" required>

                        @error('email')
                        <span class="text-danger" role="alert">
                            <p>{{ $message }}</p>
                        </span>
                        @enderror

                    </div>

                    <div class="form-group">
                        <label for="image"> Profile Picture </label>
                        <input type="file" name="image" id="image" value="{{ old('image') }}" class="form-control @error('image') is-invalid @enderror" placeholder="Enter profile picture">

                        @error('image')
                        <span class="text-danger" role="alert">
                            <p>{{ $message }}</p>
                        </span>
                        @enderror

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success mr-2">Update</button>
                </div>
            </form>
            </div>
        </div>
    </div>

     {{-- Change Area Modal form --}}
        <div class="modal fade" id="ChangeArea" tabindex="-1" role="dialog" aria-labelledby="ChangeArea" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="area">Change Area</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ route('admin.request-area')}}" method="POST">
                 @csrf
                <div class="modal-body">
                   <div class="form-group">
                        <label for="name">Area<span class="text-red">*</span></label>
                        <input type="text" name="name" id="name" value="{{ $data->areas->name  }}" class="form-control" placeholder="Enter client name" readonly>
                    </div>

                     <div class="form-group">
                        <label for="area_id">Request Area <span class="text-red">*</span></label>
                        <input type="text" name="subscriber_id" value="{{ $data->id }}" hidden>
                        <select name="area_id" id="area_id" class="form-control" required>
                            <option value="">Select Area</option>
                            @foreach ($areas as $key => $area)
                                <option value="{{ $area->id }}">{{ $area->name }}</option>
                            @endforeach
                        </select>

                        @error('area_id')
                        <span class="text-danger" role="alert">
                            <p>{{ $message }}</p>
                        </span>
                        @enderror

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </form>
            </div>
        </div>
    </div>
     {{-- Change Connection Modal form --}}
        <div class="modal fade" id="ChangeConnection" tabindex="-1" role="dialog" aria-labelledby="ChangeConnection" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ChangeConnection">Change Connection</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
               <form action="{{ route('admin.request-connection')}}" method="POST">
                    @csrf
                <div class="modal-body">
                   <div class="form-group">
                        <label for="name">Connection<span class="text-red">*</span></label>
                        <input type="text" name="name" id="name" value="{{ $data->connections->name }}" class="form-control r" placeholder="Enter client name" readonly>
                    </div>

                    <div class="form-group">
                        <label for="connection_id">Request Connection<span class="text-red">*</span></label>
                        <input type="text" name="subscriber_id" value="{{ $data->id }}" hidden>
                        <select id="connection_id" name="connection_id" class="form-control @error('connection_id') is-invalid @enderror" required="">
                            <option value=""> Select conection type</option>
                                @foreach ($connections as $key => $connection)
                                <option value="{{ $connection->id }}">{{ $connection->name }}</option>
                            @endforeach
                        </select>

                        @error('connection_id')
                        <span class="text-danger" role="alert">
                            <p>{{ $message }}</p>
                        </span>
                        @enderror

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success" >Submit</button>
                </div>
            </form>
            </div>
        </div>
    </div>

     {{-- Change Package Modal form --}}
        <div class="modal fade" id="ChangePackage" tabindex="-1" role="dialog" aria-labelledby="ChangePackage" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ChangePackage">Change Connection & Package</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ route('admin.request-package')}}" method="POST">
                    @csrf
                <div class="modal-body">
                <div class="row">
                <div class="col-sm-6">
                   <div class="form-group">
                        <label for="name">Current Connection<span class="text-red">*</span></label>
                        <input type="text" name="name" id="name" value="{{ $data->connections->name }}" class="form-control" placeholder="Enter client name" readonly>
                    </div>
                </div>

                <div class="col-sm-6">
                   <div class="form-group">
                        <label for="name">Current Package<span class="text-red">*</span></label>
                        <input type="text" name="name" id="name" value="{{ $data->packages->name }}" class="form-control" placeholder="Enter client name" readonly>
                    </div>
                </div>
                </div>

                    <div class="form-group">
                        <label for="connection_id">Request Connection <span class="text-red">*</span></label>
                        <select id="connection_id" name="connection_id" class="form-control connection_id">
                            <option value=""> Select conection </option>
                            @foreach ($connections as $key => $connection)
                                <option value="{{ $connection->id }}">{{ $connection->name }}</option>
                            @endforeach
                        </select>

                    </div>

                <div class="row">
                <div class="col-sm-6">
                   <div class="form-group">
                        <input type="hidden" name="subscriber_id" value="{{ $data->id }}" >
                        <label for="package_id">Request Package <span class="text-red">*</span></label>
                        <select id="package_id" name="package_id" class="form-control package_id" required="">
                            <option value="">Select Package</option>
                        </select>

                    </div>
                </div>

                <div class="col-sm-6">
                   <div class="form-group">
                        <label for="amount"> Package Price<span class="text-red">*</span></label>
                        <input type="text" name="amount" id="amount" class="form-control" readonly>

                    </div>
                </div>
                </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </form>
            </div>
        </div>
    </div>

    @push('js')

     <script>
         // get package by connection type
      $( "select[name='connection_id']" ).change(function () {
          var connection_id = $(this).val();
          var amount = $('#amount').val();

          if(connection_id) {
              $.ajax({
                  url: "{{route('admin.all-package')}}",
                  dataType: 'Json',
                  data: {
                    id:connection_id
                },
                  success: function(data) {
                      $('select[name="package_id"]').empty();
                      $('.amount').empty();
                      $.each(data, function(key, value) {

                          $('select[name="package_id"]').append('<option value="'+value.key+'">'+ value.value +'</option>');

                          $('#amount').val(value.amount);
                      });
                  }
              });
          }
      });
    </script>
    @endpush
</x-app-layout>
