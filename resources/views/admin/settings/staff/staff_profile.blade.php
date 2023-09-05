<x-app-layout>
    @push('css')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    @endpush
    @section('title', 'Staff Profile')

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
                                                    <h5>{{ $data->name }} &nbsp;&nbsp;<a href="" title="Edit" id="editprofile"  data-toggle="modal" data-target="#EditProfile"><i class="fa fa-edit"></i></a></h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <div class="card mt-3">
                                        <ul class="list-group list-group-flush">
                                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                            <h6 class="mb-0">Designation</h6>
                                            <span class="text-secondary"> <b>{{ $data->designation ?? null}}</b></span>
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
                                            {{ $data->join_date }}
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                            <h6 class="mb-0">Gender</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                @if ($data->gender == 1 )
                                                Male
                                                    @elseif($data->gender == 2 )
                                                    Female
                                                    @else
                                                    Other
                                                @endif
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                            <h6 class="mb-0">Birth Date</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                {{ $data->birth_date }}
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                            <h6 class="mb-0">Salary</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                           {{$data->salary }} BDT
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                            <h6 class="mb-0">Status</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                @if ($data->status == 1 ) Active
                                                 @elseif ($data->status == 2 ) Inactive
                                                @endif
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
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                            <h6 class="mb-0">Description</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                            {{ $data->description ?? '--'}}
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
                    <button title="Close Button" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <form enctype="multipart/form-data" action="{{ route('admin.staff-profile-update', $data->id )}}" method="POST">
                    @csrf
                    @method('PUT')

                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="name"> Name<span class="text-red">*</span></label>
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
                        <div class="form-group">
                            <label for="description"> Address <span class="text-red">*</span></label>
                            <textarea name="address" rows="2" class="form-control" placeholder="Write address here...">{{ $data->address }}</textarea>
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

    </script>
    @endpush
</x-app-layout>
