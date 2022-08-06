<x-app-layout>

    @push('css')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    @endpush

    @section('title', 'Create Staff')

    <x-slot name="header">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="fas fa-compass"></i>
                </div>
                <div>
                    <h4>Create Staff</h4>
                </div>
            </div>
            <div class="page-title-actions">
                <a href="{{ route('admin.staff.index') }}" type="button" class="btn btn-sm btn-dark">
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
                    <div class="col-md-12" id="addrow">
                         <form enctype="multipart/form-data" action="{{ route('admin.staff.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="name"> Name<span class="text-red">*</span></label>
                                        <input type="text" name="name" id="name" value="{{ old('name')}}" class="form-control" placeholder="Enter your name" required>

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
                                        <input type="text" name="birth_date" id="birth_date" value="{{ old('birth_date') }}" class="form-control datepicker @error('birth_date') is-invalid @enderror" placeholder="Enter your birth date" required>

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

                                         <input type="text" name="join_date" id="join_date" value="{{ old('join_date') }}" class="form-control datepicker @error('join_date') is-invalid @enderror" placeholder="Enter join date" required>

                                        @error('join_date')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>


                                 <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="gender">Gender<span class="text-red">*</span></label>
                                        <br>

                                        <input type="radio"  name="gender" id="gender" value="1" required> Male &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                        <input type="radio" name="gender" id="gender" value="2" required> Female

                                         @error('gender')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="image"> Profile Picture </label>
                                        <input type="file" name="image" id="image" value="{{ old('image') }}" class="form-control @error('image') is-invalid @enderror" placeholder="Enter your profile picture" required>

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
                                        <input name="contact_no" type="text" id="contact_no" value="{{ old('contact_no') }}" class="form-control contact_no @error('contact_no') is-invalid @enderror" placeholder="Enter your contact" required>

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
                                        <input name="designation" type="text" id="designation" value="{{ old('designation') }}" class="form-control designation @error('designation') is-invalid @enderror" placeholder="Enter designation" required>

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
                                        <input name="salary" type="text" id="salary" value="{{ old('salary') }}" class="form-control salary @error('salary') is-invalid @enderror" placeholder="Enter salary" required>

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
                                        <input  type="email" name="email" id="email" value="" class="form-control email @error('email') is-invalid @enderror" placeholder="Enter ypur email" required>

                                        @error('email')
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

                                 <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="address">Address <span class="text-red">*</span></label>
                                       <textarea name="address" id="" style="height: 38px" class="form-control" placeholder="address here..." required>{!! old('address') !!}</textarea>

                                         @error('address')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="description"> Description </label>
                                        <textarea name="description" style="height: 38px" id="" class="form-control" placeholder="Describe here...">{!! old('description') !!}</textarea>
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
        <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
         <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

        <script>
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
