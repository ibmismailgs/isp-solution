<x-app-layout>

    @section('title', 'General Settings')
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
                    <h4>General Settings</h4>
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
                         <form enctype="multipart/form-data" action="{{ route('admin.general-settings-store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ isset($data) ? $data->id : ' ' }}">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="name">Company Name<span class="text-red">*</span></label>
                                        <input type="text" name="name" id="name" value="{{ isset($data) ? $data->name : old('name') }}" class="form-control" placeholder="Enter company name" required>

                                        @error('name')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="website">Company Web Address<span class="text-red">*</span></label>
                                        <input type="text" name="website" id="website" value="{{ isset($data) ? $data->website : old('website') }}" class="form-control" placeholder="Enter company web address" required>

                                        @error('name')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="email">Company Email<span class="text-red">*</span></label>
                                        <input  type="email" name="email" id="email" value="{{ isset($data) ? $data->email : old('email') }}" class="form-control email @error('email') is-invalid @enderror" placeholder="Enter email address " required>

                                        @error('email')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="phone">Company Phone<span class="text-red">*</span></label>

                                         <input type="text" name="phone" id="phone" value="{{ isset($data) ? $data->phone : old('phone') }}" class="form-control @error('phone') is-invalid @enderror" placeholder="Enter phone number" required>

                                        @error('phone')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="logo">Upload Logo<span class="text-red">*</span></label>
                                        <input type="file" name="logo" id="logo" data-height="150"
                                        @if ($data) data-default-file="{{ asset('img/' . $data->logo) }}" @endif class="dropify form-control @error('logo') is-invalid @enderror" >

                                        @error('logo')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="favicon">Upload Favicon<span class="text-red">*</span></label>
                                        <input type="file" name="favicon" id="favicon" data-height="150" @if ($data) data-default-file="{{ asset('img/' . $data->favicon) }}" @endif class="dropify form-control @error('favicon') is-invalid @enderror" >

                                        @error('favicon')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="address">Address <span class="text-red">*</span></label>
                                        <textarea name="address" class="form-control" rows="3" placeholder="Write your address..." required>{{ isset($data) ? $data->address : old('address') }}</textarea>

                                            @error('address')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="map">Map Location<span class="text-red">*</span></label>
                                        <textarea name="map" class="form-control" rows="3" placeholder="Enter map location" required>{{ isset($data) ? $data->map : old('map') }}</textarea>

                                            @error('map')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="description"> Description </label>
                                        <textarea name="description" rows="3" class="form-control" placeholder="Describe here...">{{ isset($data) ? $data->description : old('description') }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-30">
                                <div class="col-sm-12">
                                    <button title="Create Button" type="submit" class="btn btn-success mr-2">{{ isset($data) ? 'Update' : 'Create' }}</button>
                                </div>
                            </div>

                        </form>
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
