<x-app-layout>
    @push('css')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    @endpush

    @section('title', 'Edit Client Information')

    <x-slot name="header">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="fas fa-compass"></i>
                </div>
                <div>
                    <h4> Edit Client Information </h4>
                </div>
            </div>
            <div class="page-title-actions">
                <a href="{{ route('admin.subscriber.index') }}" type="button" class="btn btn-sm btn-dark">
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
                        <form action="{{ route('admin.subscriber.update', $data->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                             <div class="row">
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="subscriber_id">Client ID<span class="text-red">*</span></label>
                                        <input type="text" name="subscriber_id" id="subscriber_id" value="{{ $data->subscriber_id }}" class="form-control" placeholder="Client ID" readonly>
                                        @error('subscriber_id')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-4">
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

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="initialize_date"> Initialize Date <span class="text-red">*</span></label>
                                        <input type="text" name="initialize_date" id="initialize_date" value="{{ $data->initialize_date }}" class="form-control datepicker @error('initialize_date') is-invalid @enderror" placeholder="Enter initialize date" required>

                                        @error('initialize_date')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                    <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="birth_date">Date of Birth</label>
                                        <input type="text" name="birth_date" id="birth_date" value="{{ $data->birth_date }}" class="form-control datepicker" placeholder="Enter date of birth">

                                    </div>
                                </div>

                            </div>

                            @php
                                $cardTypes = json_decode($data->card_type_id, true);
                                $cardNumbers = json_decode($data->card_no, true);
                                $array = array_merge($cardTypes, $cardNumbers);
                            @endphp

                            @foreach( $cardTypes as $key => $value )
                                 <div class="row row_del" >
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="card_type_id">ID Card Type</label>
                                            <select name="card_type_id[]" id="card_type_id{{ $key }}"  class="form-control card_type_id">

                                            <option value="">Select ID Card Type</option>
                                            @foreach ($idcards as $idcard)
                                             <option value="{{ $idcard->id }}" @if($idcard->id == $value) selected @endif>
                                                {{ $idcard->name }} </option>
                                            @endforeach

                                            </select>

                                        </div>
                                    </div>

                                    <div class="col-sm-5">
                                        <div class="form-group">
                                            <label for="card_no">Card No. </label>
                                            <input type="text" name="card_no[]" id="card_no" value="{{$cardNumbers[$key]}} " class="form-control " placeholder="Enter card no.." >

                                        </div>
                                    </div>

                                    @if ($key == 0)
                                    <div class="col-sm-1">
                                        <div class="form-group">
                                            <button style="margin-top: 31px" type="button" name="add" id="add" class="btn btn-success">+</button>
                                        </div>
                                    </div>

                                    @else

                                    <div class="col-sm-1">
                                    <div class="form-group">
                                        <button style="margin-top: 31px" type="button" name="row_remove" id="row_remove" class="btn btn-danger row_remove">-</button>
                                    </div>
                                </div>
                                    @endif
                                </div>
                                @endforeach

                            <div  id="cardfield">

                            </div>

                            <div class="row">

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="area_id">Area <span class="text-red">*</span></label>
                                        <select name="area_id" id="area_id" class="form-control">
                                            <option value="">Select Area</option>

                                            @foreach ($areas as $key => $area)
                                                <option value="{{ $area->id }}" @if ($data->area_id == $area->id) selected @endif>{{ $area->name }}</option>
                                            @endforeach
                                        </select>

                                        @error('area_id')
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
                                        <label for="contact_no">Contact No <span class="text-red">*</span></label>
                                        <input type="text" name="contact_no" id="contact_no" value="{{ $data->contact_no }}" class="form-control @error('contact_no') is-invalid @enderror" placeholder=" Enter your contact no.." required>

                                        @error('contact_no')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="name">Client Category<span class="text-red">*</span></label>

                                       <select id="category_id" name="category_id" class="form-control @error('category_id') is-invalid @enderror" required="">
                                            <option value="">Select category</option>

                                            @foreach ($categories as $key => $category)
                                                <option value="{{ $category->id }}"  @if ($data->category_id == $category->id) selected @endif>{{ $category->name }}</option>
                                            @endforeach

                                        </select>

                                        @error('category_id')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="connection_id">Connection Type<span class="text-red">*</span></label>

                                       <select id="connection_id" name="connection_id" class="form-control @error('connection_id') is-invalid @enderror" required="">
                                            <option value=""> Select conection type</option>
                                             @foreach ($connections as $key => $connection)
                                                <option value="{{ $connection->id }}" @if ($data->connection_id == $connection->id) selected @endif>{{ $connection->name }}</option>
                                            @endforeach
                                        </select>

                                        @error('connection_id')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="package_id">Package <span class="text-red">*</span></label>

                                        <select id="package_id" name="package_id" class="form-control @error('package_id') is-invalid @enderror" >
                                             <option value="">Select Package</option>
                                            @foreach($packages as $package)
                                            <option value="{{$package->id}}" {{ $package->id == $data->package_id ? 'selected' : ' '}}>{{$package->name}}</option>
                                            @endforeach
                                        </select>

                                        @error('package_id')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="device_id">Device Type <span class="text-red">*</span></label>

                                       <select id="device_id" name="device_id" class="form-control @error('device_id') is-invalid @enderror" required="">
                                            <option value="">Select device type</option>
                                             @foreach ($devices as $device)
                                                <option value="{{ $device->id }}" @if ($data->device_id == $device->id) selected @endif>{{ $device->name }}</option>
                                            @endforeach
                                        </select>

                                        @error('device_id')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                {{-- <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="mac_address">MAC Address <span class="text-red">*</span></label>
                                        <input type="text" name="mac_address" id="mac_address" value="{{ $data->mac_address }}" class="form-control @error('mac_address') is-invalid @enderror" placeholder="Enter your mac address" required>

                                        @error('mac_address')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div> --}}

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="ip_address">IP Address <span class="text-red">*</span></label>
                                        <input type="text" name="ip_address" id="ip_address" value="{{ $data->ip_address }}" class="form-control @error('ip_address') is-invalid @enderror" placeholder="Enter your ip address" required>

                                        @error('ip_address')
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
                                            <option value="{{ $data->status }}" selected=""> @if ($data->status == 1) Active @else Inactive
                                            @endif</option>
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                           <div class="row">
                                <div class="col-sm-4">
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
                                        <label for="description"> Description </label>
                                        <textarea style="height: 38px" name="description" id="description" class="form-control" placeholder="Describe here...">{{ $data->description }}</textarea>
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
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
    <script>

        // date picker
          $(function () {
            $('.datepicker').datepicker({
                dateFormat: 'dd -M - yy'
            });
        });

    $(document).ready(function() {
         // get connection type data
         $('#connection_id').on('change',function(){
                var connection_id = $("#connection_id").val();
                 var url = "{{route('admin.all-package')}}";
                if(connection_id){
                    $('#package_id').find('option').not(':first').remove();
                    $.ajax({
                        type: "get",
                        url: url,
                        data: {
                            id: connection_id
                        },
                        success: function(response) {
                            $.each( response, function( key, value ) {
                                var option = "<option value='"+value.key+"'>"+value.value+"</option>";
                                $("#package_id").append(option);
                            });
                        }
                    });
                }
            });

         // password show on click
          showPassword.addEventListener('click', function (e) {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.classList.toggle('fa-eye-slash');
        });

        // card type multiple field append
        var length = $('#card_type_id0 > option').length;
        var max = length - 1;
        var i = 0;
        $("#add").click(function () {
            if( i < max ){
            ++i;
            $("#cardfield").append('<div class="row" id="removerow"><div class="col-sm-6"> <div class="form-group"><label for="card_type_id">ID Card Type<span class="text-red">*</span></label><select name="card_type_id[]" id="card_type_id" class="form-control card_type_id"><option value="">Select ID Card Type</option>@foreach ($idcards as $key => $idcard)<option value="{{ $idcard->id }}">{{ $idcard->name }}</option>@endforeach</select>@error('card_type_id')<span class="text-danger" role="alert"><p>{{ $message }}</p></span>@enderror</div></div><div class="col-sm-5"><div class="form-group"><label for="card_no">Card No. <span class="text-red">*</span></label><input type="text" name="card_no[]" id="card_no" value="{{ old('card_no') }}" class="form-control @error('name') is-invalid @enderror" placeholder="Enter card no.." required>@error('card_no')<span class="text-danger" role="alert"><p>{{ $message }}</p></span> @enderror</div></div><div class="col-sm-1"><div class="form-group"><button style="margin-top: 31px" type="button" name="del" id="del" class="btn btn-danger btn_remove">-</button></div></div></div>');
                }else{
                    alert("You've exhausted all of your options");
                }
            });

            $(document).on('click', '.btn_remove', function() {
                $(this).parents('#removerow').remove();
                i--;
            });

            // card type duplicate validation check
             $(document).on('click', 'select.card_type_id', function () {
                $('select[name*="card_type_id[]"] option').attr('disabled',false);
                $('select[name*="card_type_id[]"]').each(function(){
                    var $this = $(this);
                    $('select[name*="card_type_id[]"]').not($this).find('option').each(function(){
                        if($(this).attr('value') == $this.val())
                        $(this).attr('disabled',true);
                    });
                });
                });

                $(document).on('click', '.row_remove', function() {
                    var data = confirm("Are you sure want to remove. ");

                    if (data == true) {
                        $(this).parents('.row_del').remove();
                    }
                    else {
                        return false;
                    }
                });

        });
    </script>
    @endpush

</x-app-layout>

