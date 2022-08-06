<x-app-layout>

    @section('title', 'Edit Complaint')

    <x-slot name="header">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="fas fa-compass"></i>
                </div>
                <div>
                    <h4>Edit Complaint</h4>
                </div>
            </div>
            <div class="page-title-actions">
                <a href="{{ route('admin.complaint.index') }}" type="button" class="btn btn-sm btn-dark">
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
                    <div class="col-md-12">
                        <form action="{{ route('admin.complaint.update', $data->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">

                                 <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="ticket_id">Ticket ID<span class="text-red">*</span></label>
                                        <input type="text" name="ticket_id" id="ticket_id" value="{{ $data->ticket_id }}" class="form-control" readonly>
                                    </div>
                                </div>

                                  <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="classification_id "> Ticket Type<span class="text-red">*</span></label>

                                        <select id="classification_id" name="classification_id" class="form-control @error('classification_id') is-invalid @enderror" required="">

                                             @foreach($classifications as $classification)
                                        <option value="{{$classification->id}}" {{ $classification->id == $data->classification_id ? 'selected' : ' '}}>
                                            {{$classification->name}}
                                        </option>
                                            @endforeach
                                        </select>

                                         @error('classification_id')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="name">Name<span class="text-red">*</span></label>
                                        <input type="text" name="name" id="name" value="{{ $data->name }}" class="form-control @error('name') is-invalid @enderror" placeholder="Enter a name" required>

                                        @error('name')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="address">Address<span class="text-red">*</span></label>
                                        <textarea name="address" id="address" style="height: 38px" class="form-control" placeholder="Enter your address">{{ $data->address }}</textarea>

                                        @error('address')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                 <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="contact_no">Contact<span class="text-red">*</span></label>
                                        <input type="text" name="contact_no" id="contact_no" value="{{ $data->contact_no }}" class="form-control @error('contact_no') is-invalid @enderror" placeholder="Enter your contact number" required>

                                        @error('contact_no')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>
                                 <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="email">Email<span class="text-red">*</span></label>
                                        <input type="email" name="email" id="email" value="{{ $data->email }}" class="form-control @error('name') is-invalid @enderror" placeholder="Enter your email" required>

                                        @error('email')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="piority"> Piority <span class="text-red">*</span></label>
                                        <select name="piority" id="piority" class="form-control">
                                            <option value="{{ $data->piority }}" selected=""> @if ($data->piority == 1) High @else Low
                                            @endif</option>
                                            <option value="1">High</option>
                                            <option value="0">Low</option>
                                        </select>

                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="ticket_option"> Ticket Option <span class="text-red">*</span></label>
                                         <select name="ticket_option" id="ticket_option" class="form-control">
                                            <option value="{{ $data->ticket_option }}" selected=""> @if ($data->ticket_option == 1) Open @else Close
                                            @endif</option>
                                            <option value="1">Open</option>
                                            <option value="0">Close</option>
                                        </select>
                                    </div>
                                </div>

                                 <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="operator_name">Operaotr Name<span class="text-red">*</span></label>
                                        <input type="text" name="operator_name" id="operator_name" value="{{ $data->operator_name }}" class="form-control @error('operator_name') is-invalid @enderror" placeholder="Enter operator name" required>

                                        @error('operator_name')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="description"> Description </label>
                                        <textarea class="form-control h-10" name="description"  id="description" class="form-control" placeholder="Describe here...">{{ $data->description }}</textarea>
                                    </div>
                                </div>

                            </div>
                            <div class="row mt-30">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-success mr-2">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
    @push('js')
        <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

    <script>
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
