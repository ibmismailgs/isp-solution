<x-app-layout>
    @section('title', 'Edit Team')
    @push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css" integrity="sha512-EZSUkJWTjzDlspOoPSpUFR0o0Xy7jdzW//6qhUkoZ9c4StFkVsp9fbbd0O06p9ELS3H486m4wmrCELjza4JEog=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        .dropify-wrapper .dropify-message p {
            font-size: initial;
        }
    </style>

    @endpush
    <x-slot name="header">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="fas fa-compass"></i>
                </div>
                <div>
                    <h4>Edit Team</h4>
                </div>
            </div>
            <div class="page-title-actions">
                <a title="Back Button" href="{{ route('admin.team-setting.index') }}" type="button" class="btn btn-sm btn-dark">
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
                        <form enctype="multipart/form-data" action="{{ route('admin.team-setting.update', $data->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="name">Name<span class="text-red">*</span></label>
                                        <input type="text" name="name" id="name" value="{{ $data->name }}" class="form-control @error('name') is-invalid @enderror" placeholder="Enter name" required>

                                        @error('name')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="designation">Designation<span class="text-red">*</span></label>
                                        <input type="text" name="designation" id="designation" value="{{ $data->designation }}" class="form-control @error('designation') is-invalid @enderror" placeholder="Enter designation" required>

                                        @error('designation')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="phone">Phone<span class="text-red">*</span></label>
                                        <input type="text" name="phone" id="phone" value="{{ $data->phone }}" class="form-control @error('phone') is-invalid @enderror" placeholder="Enter phone" required>

                                        @error('phone')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="email">Email<span class="text-red">*</span></label>
                                        <input type="email" name="email" id="email" value="{{ $data->email }}" class="form-control @error('email') is-invalid @enderror" placeholder="Enter email" required>

                                        @error('email')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                 <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="status">Status<span class="text-red">*</span></label>
                                        <select name="status" id="status" class="form-control">
                                            <option value="1" {{ $data->status == 1 ? 'selected' : '' }}>Active</option>
                                            <option value="0" {{ $data->status == 0 ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="facebook">Facebook<span class="text-red">*</span></label>
                                        <input type="text" name="facebook" id="facebook" value="{{ $data->facebook }}" class="form-control @error('facebook') is-invalid @enderror" placeholder="Enter facebook link" required>

                                        @error('facebook')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="instagram">Instagram<span class="text-red">*</span></label>
                                        <input type="text" name="instagram" id="instagram" value="{{ $data->instagram }}" class="form-control @error('instagram') is-invalid @enderror" placeholder="Enter instagram link" required>

                                        @error('instagram')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="twitter">Twitter<span class="text-red">*</span></label>
                                        <input type="text" name="twitter" id="twitter" value="{{ $data->twitter }}" class="form-control @error('twitter') is-invalid @enderror" placeholder="Enter twitter link" required>

                                        @error('twitter')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="linkedin">LinkedIn<span class="text-red">*</span></label>
                                        <input type="text" name="linkedin" id="linkedin" value="{{ $data->linkedin }}" class="form-control @error('linkedin') is-invalid @enderror" placeholder="Enter linkedin link" required>

                                        @error('linkedin')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="profile_picture">Profile Picture</label>
                                        <input type="file" name="profile_picture" id="profile_picture" data-height="100" data-default-file="{{ asset('img/' . $data->profile_picture) }}" class="dropify form-control @error('profile_picture') is-invalid @enderror" >

                                        @error('profile_picture')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="address">Address<span class="text-red">*</span></label>
                                        <textarea name="address" class="form-control @error('answer') is-invalid @enderror" rows="4" placeholder="Write address here.." required>{{ $data->address }}</textarea>

                                        @error('address')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="description">Description<span class="text-red">*</span></label>
                                        <textarea name="description" class="form-control @error('answer') is-invalid @enderror" rows="4" placeholder="Write description here.." required>{{ $data->description }}</textarea>

                                        @error('description')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                            </div>
                            <div class="row mt-30">
                                <div class="col-sm-12">
                                    <button title="Submit Button" type="submit" class="btn btn-success mr-2">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('js')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"
        integrity="sha512-8QFTrG0oeOiyWo/VM9Y8kgxdlCryqhIxVeRpWSezdRRAvarxVtwLnGroJgnVW9/XBRduxO/z1GblzPrMQoeuew==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

        <script>
            $(document).ready(function() {
                $('.dropify').dropify();
            });
        </script>
    @endpush
</x-app-layout>
