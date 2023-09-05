<x-app-layout>

    @push('css')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    @endpush

    @section('title', 'Edit Staff')

    <x-slot name="header">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="fas fa-compass"></i>
                </div>
                <div>
                    <h4>Edit Staff</h4>
                </div>
            </div>
            <div class="page-title-actions">
                <a title="Back Button" href="{{ route('admin.staff.index') }}" type="button" class="btn btn-sm btn-dark">
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
                    <div class="col-md-12" id="addrow">
                         <form enctype="multipart/form-data" action="{{ route('admin.staff.update', $data->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="name"> Name<span class="text-red">*</span></label>
                                        <input type="text" name="name" id="name" value="{{ old('name', $data->name)}}" class="form-control" placeholder="Enter your name">

                                        @error('name')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="birth_date"> Date Of Birth <span class="text-red">*</span></label>
                                        <input type="text" name="birth_date" id="birth_date" value="{{ old('birth_date', $data->birth_date) }}" class="form-control datepicker @error('date') is-invalid @enderror" placeholder="Enter your birth date" required>

                                        @error('birth_date')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="join_date">Join Date<span class="text-red">*</span></label>

                                         <input type="text" name="join_date" id="join_date" value="{{ old('join_date', $data->join_date) }}" class="form-control datepicker @error('join_date') is-invalid @enderror" placeholder="Enter join date" required>

                                        @error('join_date')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="gender"> Select Gender <span class="text-red">*</span></label>
                                        <select name="gender" id="gender" class="form-control" required>
                                            <option value="">Select Gender</option>
                                            <option value="1" {{ $data->gender == 1 ? 'selected' : '' }}>Male</option>
                                            <option value="2" {{ $data->gender == 2 ? 'selected' : '' }}>Female</option>
                                            <option value="3" {{ $data->gender == 3 ? 'selected' : '' }}>Other</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="image"> Profile Picture </label>
                                        <input type="file" name="image" id="image"  class="form-control @error('image') is-invalid @enderror" placeholder="Enter your profile picture">

                                        @error('image')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                   <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="contact_no"> Contact <span class="text-red">*</span></label>
                                        <input name="contact_no" type="text" id="contact_no" value="{{ $data->contact_no }}" class="form-control contact_no @error('contact_no') is-invalid @enderror" placeholder="Enter your contact" required>

                                        @error('contact_no')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="designation"> Designation <span class="text-red">*</span></label>
                                        <input name="designation" type="text" id="designation" value="{{ old('designation' , $data->designation) }}" class="form-control designation @error('designation') is-invalid @enderror" placeholder="Enter designation" required>

                                        @error('designation')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="salary"> Salary <span class="text-red">*</span></label>
                                        <input name="salary" type="number" id="salary" value="{{ old('salary' , $data->salary) }}" class="form-control salary @error('salary') is-invalid @enderror" placeholder="Enter salary" required>

                                        @error('salary')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="email"> Email <span class="text-red">*</span></label>
                                        <input  type="email" name="email" id="email" value="{{ $data->email }}" class="form-control email @error('email') is-invalid @enderror" placeholder="Enter your email" required>

                                        @error('email')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                 <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="password"> Password <span class="text-red">*</span></label>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <span id="showPassword" class="fa fa-eye"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        @error('password')
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
                                            <option value="1" {{ $data->status == 1 ? 'selected' : '' }}>Active</option>
                                            <option value="0" {{ $data->status == 0 ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                    </div>
                                </div>

                                   <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="address">Address<span class="text-red">*</span></label>
                                       <textarea name="address" rows="3" class="form-control" placeholder="write your address...">{{ $data->address }}</textarea>

                                         @error('address')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="description"> Description </label>
                                        <textarea name="description" rows="3" class="form-control" placeholder="Describe here...">{{ $data->description }}</textarea>
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
        <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
         <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

        <script>

            // password show on click
          showPassword.addEventListener('click', function (e) {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.classList.toggle('fa-eye-slash');
        });

             // date picker
            $(function () {
                $('.datepicker').datepicker({
                    dateFormat: 'dd MM yy'
                });
            });

            //text editor
            tinymce.init({
                selector: '#description',
                plugins: [
                'a11ychecker','advlist','advcode','advtable','autolink','checklist','export',
                'lists','link','image','charmap','preview','anchor','searchreplace','visualblocks',
                'powerpaste','fullscreen','formatpainter','insertdatetime','media','table','help','wordcount'
                ],
                toolbar: 'undo redo | formatpainter casechange blocks | bold italic backcolor | ' +
                'alignleft aligncenter alignright alignjustify | ' +
                'bullist numlist checklist outdent indent | removeformat | a11ycheck code table help'
            });

        </script>
    @endpush
</x-app-layout>
