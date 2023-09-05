<x-app-layout>

    @section('title', 'Faq Color Settings')
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
                    <h4>Faq Color Settings</h4>
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
                         <form enctype="multipart/form-data" action="{{ route('admin.faq-color-store') }}" method="POST">
                            @csrf

                            <input type="hidden" name="id" value="{{ isset($data) ? $data->id : ' ' }}">

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="heading_color">Heading Text Color</label>
                                        <input type="color" name="heading_color" id="heading_color" value="{{ isset($data) ? $data->heading_color : old('heading_color') }}" class="form-control @error('heading_color') is-invalid @enderror" placeholder="Enter heading color" required>

                                        @error('heading_color')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="underline_color">Heading Underline Color</label>
                                        <input type="color" name="underline_color" id="underline_color" value="{{ isset($data) ? $data->underline_color : old('underline_color') }}" class="form-control @error('underline_color') is-invalid @enderror" placeholder="Enter heading color" required>

                                        @error('underline_color')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="question_color">Question Text Color</label>
                                        <input type="color" name="question_color" id="question_color" value="{{ isset($data) ? $data->question_color : old('question_color') }}" class="form-control @error('question_color') is-invalid @enderror" placeholder="Enter color" required>

                                        @error('question_color')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="answer_color">Answer Text Color</label>
                                        <input type="color" name="answer_color" id="answer_color" value="{{ isset($data) ? $data->answer_color : old('answer_color') }}" class="form-control @error('answer_color') is-invalid @enderror" placeholder="Enter color" required>

                                        @error('answer_color')
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
