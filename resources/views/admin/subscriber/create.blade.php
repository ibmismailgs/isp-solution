<x-app-layout>
    @push('css')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    @endpush
    @section('title', 'Create Client')
    <x-slot name="header">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="fas fa-compass"></i>
                </div>
                <div>
                    <h4> Client Information </h4>
                </div>
            </div>
            <div class="page-title-actions">
                <a title="Back Button" href="{{ route('admin.subscriber.index') }}" type="button" class="btn btn-sm btn-dark">
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
                    <div class="col-md-12">
                        <form action="{{ route('admin.subscriber.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="subscriber_id">Client ID<span class="text-red">*</span></label>
                                        <input type="text" name="subscriber_id" id="subscriber_id" value="SID-{{ $sid +1 }}" class="form-control" placeholder="Client ID" readonly>

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
                                        <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" placeholder="Enter client name" required>

                                        @error('name')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="initialize_date"> Join Date <span class="text-red">*</span></label>
                                        <input type="text" name="initialize_date" id="initialize_date" value="{{ old('initialize_date') }}" class="form-control datepicker @error('initialize_date') is-invalid @enderror" placeholder="Enter initialize date" required>

                                        @error('initialize_date')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="birth_date"> Date of Birth</label>
                                        <input type="text" name="birth_date" id="birth_date" value="{{ old('birth_date') }}" class="form-control datepicker" placeholder="Enter date of birth">

                                    </div>
                                </div>

                            </div>

                            <div class="row">

                                <div class="col-sm-7">
                                    <div class="form-group">
                                        <label for="card_type_id">ID Card Type</label>

                                        <select name="card_type_id[]" id="card_type_id" class="form-control card_type_id">
                                            <option value="">Select ID Card Type</option>
                                            @foreach ($idcards as $key => $idcard)
                                                <option value="{{ $idcard->id }}">{{ $idcard->name }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="card_no">Card No.</label>
                                        <input type="text" name="card_no[]" id="card_no" value="{{ old('card_no') }}" class="form-control" placeholder="Enter card no.." >

                                    </div>
                                </div>

                                <div class="col-sm-1">
                                    <div class="form-group">
                                        <button style="margin-top: 31px" type="button" name="add" id="add" class="btn btn-success">+</button>
                                    </div>
                                </div>
                            </div>

                            <div  id="cardfield">

                            </div>

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="area_id">Area <span class="text-red">*</span></label>
                                        <select name="area_id" id="area_id" class="form-control">
                                            <option value="">Select Area</option>
                                            @foreach ($areas as $key => $area)
                                                <option value="{{ $area->id }}">{{ $area->name }}</option>
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
                                        <label for="contact_no">Contact No <span class="text-red">*</span></label>
                                        <input type="text" name="contact_no" id="contact_no" value="{{ old('contact_no') }}" class="form-control @error('contact_no') is-invalid @enderror" placeholder=" Enter your contact no.." required>

                                        @error('contact_no')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="name">Client Category<span class="text-red">*</span></label>

                                       <select id="category_id" name="category_id" class="form-control @error('category_id') is-invalid @enderror" required="">
                                            <option value="">Select category</option>
                                            @foreach ($categories as $key => $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach

                                        </select>

                                        @error('category_id')
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
                                        <label for="connection_id">Connection Type<span class="text-red">*</span></label>

                                       <select id="connection_id" name="connection_id" class="form-control @error('connection_id') is-invalid @enderror" required="">
                                            <option value=""> Select conection type</option>
                                             @foreach ($connections as $key => $connection)
                                                <option value="{{ $connection->id }}">{{ $connection->name }}</option>
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

                                       <select id="package_id" name="package_id" class="form-control @error('package_id') is-invalid @enderror" required="">
                                            <option value="">Select Package</option>

                                        </select>

                                        @error('package_id')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="device_id">Device Type <span class="text-red">*</span></label>

                                       <select id="device_id" name="device_id" class="form-control @error('device_id') is-invalid @enderror" required="">
                                            <option value="">Select device type</option>
                                             @foreach ($devices as $device)
                                                <option value="{{ $device->id }}">{{ $device->name }}</option>
                                            @endforeach
                                        </select>

                                        @error('device_id')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="ip_address">IP Address <span class="text-red">*</span></label>
                                        <input type="text" name="ip_address" id="ip_address" value="{{ old('ip_address') }}" class="form-control @error('ip_address') is-invalid @enderror" placeholder="Enter your ip address" required>

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
                                            <option value="1" @if (old('status') == "1") {{ 'selected' }} @endif>Active</option>
                                            <option value="0" @if (old('status') == "0") {{ 'selected' }} @endif>Inactive</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="email">Email <span class="text-red">*</span></label>
                                        <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="Enter your email"  autocomplete="off" required>

                                        @error('email')
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
                                        <label for="password"> Password <span class="text-red">*</span></label>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required="required" autocomplete="off">
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
                                </div>

                                  <div class="row">
                                    <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="address">Address<span class="text-red">*</span></label>
                                        <textarea rows="3" name="address" id="address" class="form-control" placeholder="Enter your address">{!! old('address') !!}</textarea>

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
                                        <textarea rows="3" name="description" id="description" class="form-control" placeholder="Describe here...">{!! old('description') !!}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-30">
                                <div class="col-sm-12">
                                    <button title="Create Button" type="submit" class="btn btn-success mr-2">Create</button>
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
                dateFormat: 'dd MM yy'
            });
        });

    $(document).ready(function() {

         // get package by connection type
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
        var length = $('#card_type_id > option').length;
        var max = length - 1;
        var i = 0;
        $("#add").click(function () {
            if( i < max ){
            ++i;
            $("#cardfield").append('<div class="row" id="removerow"><div class="col-sm-7"> <div class="form-group"><label for="card_type_id">ID Card Type</label><select name="card_type_id[]" id="card_type_id" class="form-control card_type_id"><option value="">Select ID Card Type</option>@foreach ($idcards as $key => $idcard)<option value="{{ $idcard->id }}">{{ $idcard->name }}</option>@endforeach</select>@error('card_type_id')<span class="text-danger" role="alert"><p>{{ $message }}</p></span>@enderror</div></div><div class="col-sm-4"><div class="form-group"><label for="card_no">Card No. </label><input type="text" name="card_no[]" id="card_no" value="{{ old('card_no') }}" class="form-control @error('name') is-invalid @enderror" placeholder="Enter card no..">@error('card_no')<span class="text-danger" role="alert"><p>{{ $message }}</p></span> @enderror</div></div><div class="col-sm-1"><div class="form-group"><button style="margin-top: 31px" type="button" name="del" id="del" class="btn btn-danger btn_remove">-</button></div></div></div>');
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
        });
    </script>
    @endpush
</x-app-layout>
