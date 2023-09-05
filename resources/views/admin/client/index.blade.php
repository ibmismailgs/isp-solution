<x-app-layout>
    @push('css')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    @endpush
    @section('title', 'Client Profile')

    <x-slot name="header">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                </div>
                <div>
                    Welcome <b>{{Auth::user()->name}}</b>
                    <div class="page-title-subheading">
                       Internet Service Provider (ISP)
                    </div>
                </div>
            </div>

                <div class="filter-toggle btn-group page-title-actions">

                    <button title="Profile Edit Button" style="border-top-left-radius: 15px; border-bottom-left-radius: 15px;" class="btn btn-secondary date-btn " id="editprofile"  data-toggle="modal" data-target="#EditProfile">Edit Profile</button>

                    <button title="Change Area Button" class="btn btn-secondary date-btn " id="area"  data-toggle="modal" data-target="#ChangeArea">Change Area</button>

                    <button title="Package Change Button" style="border-top-right-radius: 15px; border-bottom-right-radius: 15px;" class="btn btn-secondary date-btn " id="package"  data-toggle="modal" data-target="#ChangePackage">Change Connection & Package</button>

                </div>
        </div>

    </x-slot>

    <div class="container-fluid">
    	<div class="page-header">
            <div class="d-inline">
                @if (Session::has('message'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{Session::get('message')}}
                        <button title="Close Button" type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

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
    </div>

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="container">
                            <div class="main-body">
                                <div class="row gutters-sm">
                                    <div class="col-md-4 mb-3">

                                        <div class="card" >
                                            <div class="card-body">
                                                <div class="d-flex flex-column align-items-center text-center">
                                                    <img src="{{asset('img/'.$data->image)}}" alt="Profile Picture Missing" class="rounded-circle" width="150">
                                                    <div class="mt-3">
                                                    <h5>{{ $data->name }}</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <div class="card mt-3">
                                        <ul class="list-group list-group-flush">
                                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                            <h6 class="mb-0">Client ID</h6>
                                            <span class="text-secondary"> <b>{{ $data->subscriber_id ?? null}}</b></span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                            <h6 class="mb-0">Contact No</h6>
                                            <span class="text-secondary"> <b>{{ $data->contact_no ?? null}}</b></span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                            <h6 class="mb-0">Email</h6>
                                            <span class="text-secondary"> <b>{{ $data->email  }}</b></span>
                                        </li>
                                        </ul>
                                    </div>
                                    </div>
                                    <div class="col-md-8">
                                    <div class="card mb-3">
                                        <div class="card-body">
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
                                            <h6 class="mb-0">Area Name</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                           {{ $data->areas->name ?? '--' }}
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                            <h6 class="mb-0">Connection Name</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                           {{ $data->connections->name ?? '--' }}
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
                                            <h6 class="mb-0">Package Name</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                            {{ $data->packages->name ?? '--'}} , {{ $data->packages->package_spreed ?? '--' }}
                                            </div>
                                        </div>
                                        <hr>

                                        <div class="row">
                                            <div class="col-sm-3">
                                            <h6 class="mb-0">Category</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                            {{ $data->categories->name ?? '--'}}
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
                                        </div>
                                    </div>
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
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="name">Client Name<span class="text-red">*</span></label>
                                <input type="text" name="name" id="name" value="{{ $data->name }}" class="form-control @error('name') is-invalid @enderror" placeholder="Enter client name" required>

                                @error('name')
                                <span class="text-danger" role="alert">
                                    <p>{{ $message }}</p>
                                </span>
                                @enderror

                            </div>
                            </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="contact_no">Contact No <span class="text-red">*</span></label>
                                <input type="text" name="contact_no" id="contact_no" value="{{ $data->contact_no }}" class="form-control @error('contact_no') is-invalid @enderror" placeholder=" Enter your contact no.." required>

                                @error('contact_no')
                                <span class="text-danger" role="alert">
                                    <p>{{ $message }}</p>
                                </span>
                                @enderror
                            </div>

                        </div>

                     <div class="col-sm-6">
                     <div class="form-group">
                        <label for="email">Email <span class="text-red">*</span></label>
                        <input type="email" name="email" id="email" value="{{ $data->email }}" class="form-control @error('email') is-invalid @enderror" placeholder="Enter your email" required>

                        @error('email')
                        <span class="text-danger" role="alert">
                            <p>{{ $message }}</p>
                        </span>
                        @enderror

                    </div>
                    </div>

                    <div class="col-sm-6">
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

                    <div class="col-sm-12">
                        <label for="image"> Password Change : </label>&nbsp;
                        <input type="checkbox" id="password_change" onclick="passChange()">
                    </div>

                    <span id="text" style="display: none">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-6">
                                <label for="password">New Password <span class="text-red">*</span></label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter new password" autocomplete="off">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <span id="showPassword" class="fa fa-eye"></span>
                                            </span>
                                        </div>
                                    </div>
                                @error('password')
                                <span class="text-danger" role="alert">
                                    <p>{{ $message }}</p>
                                </span>
                                @enderror

                            </div>
                        </div>

                        <div class="col-sm-6">
                                <label for="password">Confirm Password <span class="text-red">*</span></label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="confirm_password" onChange="checkPasswordMatch();" name="confirm_password" placeholder="Enter confirm password" autocomplete="off">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <span id="showConfirm_password" class="fa fa-eye"></span>
                                            </span>
                                        </div>
                                    </div>
                            </div>
                        </div>

                        <p class="col-sm-12 text-danger" role="alert" id="passwordMessage"></p>
                    </div>
                    </div>
                </span>
                </div>
                </div>
                <div class="modal-footer">
                    <button title="Cancel Button" type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    <button title="Update Button" type="submit" class="btn btn-success mr-2">Update</button>
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
                    <input type="hidden" value="{{ $data->areas->id }}" id="area_name" name="area_name">
                    <input type="text" name="name"  value="{{ $data->areas->name ?? null}}" class="form-control" placeholder="Enter client name" readonly>
                    </div>

                     <div class="form-group">
                        <label for="area_id">Request Area <span class="text-red">*</span></label>
                        <input type="text" name="subscriber_id" value="{{ $data->id }}" hidden>
                        <select onchange="checkArea()" name="area_id" id="area_id" class="form-control" required>
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

                        <span class="text-danger" role="alert">
                            <p id="show"></p>
                        </span>

                    </div>
                </div>
                <div class="modal-footer">
                    <button title="Cancel Button" type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    <button title="Submit Button" type="submit" class="btn btn-success">Submit</button>
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
                        <input type="hidden" value="{{ $data->connections->id }}" id="connection_name" name="connection_name">
                        <input type="text" name="name" value="{{ $data->connections->name ?? null }}" class="form-control" placeholder="Enter client name" readonly>
                    </div>
                </div>

                <div class="col-sm-6">
                   <div class="form-group">
                        <label for="name">Current Package<span class="text-red">*</span></label>
                        <input type="text" name="name" value="{{ $data->packages->name ?? null}}" class="form-control" placeholder="Enter client name" readonly>
                    </div>
                </div>
                </div>

                    <div class="form-group">
                        <label for="connection_id">Request Connection <span class="text-red">*</span></label>
                        <select onchange="checkConnection()" id="connection_id" name="connection_id" class="form-control connection_id">
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

                <span class="text-danger" role="alert">
                    <p id="showMsg"></p>
                </span>
                </div>

                </div>
                <div class="modal-footer">
                    <button title="Cancel Button" type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    <button title="Submit Button" type="submit" class="btn btn-success">Submit</button>
                </div>
            </form>
            </div>
        </div>
    </div>

    @push('js')
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script>

    //checkPasswordMatch
    function checkPasswordMatch() {
            var password = $("#password").val();
            var confirmPassword = $("#confirm_password").val();

            if (confirmPassword != password)
                $("#passwordMessage").html("Passwords do not match!");
            else
                $("#passwordMessage").html("Passwords match.");
        }

        $("#confirm_password").keyup(checkPasswordMatch);

        // password show on click
        showPassword.addEventListener('click', function (e) {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                this.classList.toggle('fa-eye-slash');
            })

        showConfirm_password.addEventListener('click', function (e) {
            const type = confirm_password.getAttribute('type') === 'password' ? 'text' : 'password';
            confirm_password.setAttribute('type', type);
                this.classList.toggle('fa-eye-slash');
            })

        function passChange() {
            var checkBox = document.getElementById("password_change");
            var text = document.getElementById("text");
            if (checkBox.checked == true){
                text.style.display = "block";
            } else {
                text.style.display = "none";
            }
        }

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

      //area validation
        function checkArea() {
            var area = $("#area_name").val();
            var request_area = $("#area_id").val();

            if (request_area == area){
                $("#show").html("You are already in this area");
                $("#area_id").val('null');
            }
        }

      //connection validation
        function checkConnection() {
            var connection = $("#connection_name").val();
            var request_connection = $("#connection_id").val();
            if (request_connection == connection){
                $("#showMsg").html("You are already using this connection & package");
                $("#connection_id").val('null');
                $("#package_id").val('null');
            }
        }

    </script>
    @endpush
</x-app-layout>
