<x-app-layout>
    @section('title', 'Social Link Settings')
    @push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css" integrity="sha512-EZSUkJWTjzDlspOoPSpUFR0o0Xy7jdzW//6qhUkoZ9c4StFkVsp9fbbd0O06p9ELS3H486m4wmrCELjza4JEog==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
                    <h4>Social Link Settings</h4>
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
                         <form enctype="multipart/form-data" action="{{ route('admin.social-link-store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ isset($data) ? $data->id : ' ' }}">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="facebook">Facebook<span class="text-red">*</span></label>
                                        <textarea name="facebook" class="form-control @error('facebook') is-invalid @enderror" rows="2" placeholder="Enter facebook link" required>{{ isset($data) ? $data->facebook : old('facebook') }}</textarea>

                                        @error('facebook')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="youtube">Youtube<span class="text-red">*</span></label>
                                        <textarea name="youtube" class="form-control @error('youtube') is-invalid @enderror" rows="2" placeholder="Enter youtube link" required>{{ isset($data) ? $data->youtube : old('youtube') }}</textarea>

                                        @error('youtube')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="linkedin">Linkedin<span class="text-red">*</span></label>
                                        <textarea name="linkedin" class="form-control @error('linkedin') is-invalid @enderror" rows="2" placeholder="Enter linkedin link" required>{{ isset($data) ? $data->linkedin : old('linkedin') }}</textarea>

                                        @error('linkedin')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="instagram">Instagram<span class="text-red">*</span></label>
                                        <textarea name="instagram" class="form-control @error('answer') is-invalid @enderror" rows="2" placeholder="Enter instagram link" required>{{ isset($data) ? $data->instagram : old('instagram') }}</textarea>

                                        @error('instagram')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="twitter">Twitter<span class="text-red">*</span></label>
                                        <textarea name="twitter" class="form-control @error('answer') is-invalid @enderror" rows="2" placeholder="Enter twitter link" required>{{ isset($data) ? $data->twitter : old('twitter') }}</textarea>

                                        @error('twitter')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="description">Description<span class="text-red">*</span></label>
                                        <textarea name="description" class="form-control @error('answer') is-invalid @enderror" rows="2" placeholder="Write description here.." required>{{ isset($data) ? $data->description : old('description') }}</textarea>

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
