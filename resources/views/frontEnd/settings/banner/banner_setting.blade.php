<x-app-layout>

    @section('title', 'Banner Settings')
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
                    <h4>Banner Settings</h4>
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
                         <form enctype="multipart/form-data" action="{{ route('admin.banner-setting-store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ isset($data) ? $data->id : ' ' }}">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="color">Background Color</label>
                                        <input type="color" name="color" id="color" value="{{ isset($data) ? $data->color : old('color') }}" class="form-control" placeholder="Enter background color">

                                        @error('color')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="title_color">Title Text Color</label>
                                        <input type="color" name="title_color" id="title_color" value="{{ isset($data) ? $data->title_color : old('title_color') }}" class="form-control" placeholder="Enter title color">

                                        @error('title_color')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="text_color">Sub-Title Text Color</label>
                                        <input type="color" name="text_color" id="text_color" value="{{ isset($data) ? $data->text_color : old('text_color') }}" class="form-control" placeholder="Enter text color" >

                                        @error('text_color')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="title">Title<span class="text-red">*</span></label>
                                        <textarea name="title" class="form-control" rows="2" placeholder="Write title..." required>{{ isset($data) ? $data->title : old('title') }}</textarea>

                                        @error('title')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="sub_title">Sub-Title<span class="text-red">*</span></label>
                                        <textarea name="sub_title" class="form-control" rows="2" placeholder="Write sub title..." required>{{ isset($data) ? $data->sub_title : old('sub_title') }}</textarea>

                                        @error('sub_title')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="banner_image">Banner Image<span class="text-red">*</span></label>
                                        <input type="file" name="banner_image" id="banner_image" data-height="150" @if ($data) data-default-file="{{ asset('img/' . $data->banner_image) }}" @endif class="dropify form-control @error('banner_image') is-invalid @enderror" >

                                        @error('banner_image')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

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
