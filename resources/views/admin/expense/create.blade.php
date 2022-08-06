<x-app-layout>

    @push('css')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    @endpush

    @section('title', 'Create Expense')

    <x-slot name="header">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="fas fa-compass"></i>
                </div>
                <div>
                    <h4>Create Expense</h4>
                </div>
            </div>
            <div class="page-title-actions">
                <a href="{{ route('admin.expense.index') }}" type="button" class="btn btn-sm btn-dark">
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
                         <form enctype="multipart/form-data" action="{{ route('admin.expense.store') }}" method="POST">
                            @csrf
                            <div class="row">

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="expense_number">Invoice No<span class="text-red">*</span></label>
                                        <input type="text" name="expense_number" id="expense_number" value="Expense-{{ $expense_num + 1 }}" class="form-control" readonly>

                                        @error('expense_number')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                {{-- <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="name"> Staff Name <span class="text-red">*</span></label>
                                         <select name="staff_id" id="staff_id" class="form-control">
                                            <option value=""> Select </option>
                                             @foreach ($staffs as $key => $value)
                                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('name')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div> --}}

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="date"> Date <span class="text-red">*</span></label>
                                        <input type="text" name="date" id="date" value="{{ old('date') }}" class="form-control datepicker @error('date') is-invalid @enderror" placeholder="Enter date" required>

                                        @error('date')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="status"> Account <span class="text-red">*</span></label>
                                            <select name="account_id" id="account_id" class="form-control">
                                                <option value="">Select Account</option>
                                                @foreach ($accounts as $key=> $account)
                                                <option value="{{ $account->id }}">{{ $account->name }}</option>
                                                @endforeach

                                            </select>
                                            @error('account_id')
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
                                        <label for="category_id">Expense-Type<span class="text-red">*</span></label>

                                        <select name="category_id[]" id="category_id" class="form-control category_id">
                                            <option value="">Select Expense-Category</option>
                                            @foreach ($categories as $key => $value)
                                                <option value="{{ $value->id }}">{{ $value->name }}</option>
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
                                        <label for="image"> File Upload </label>
                                        <input type="file" name="image[]" id="image" value="{{ old('image') }}" class="form-control @error('image') is-invalid @enderror" placeholder="Enter image">

                                        @error('image')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="amount"> Expense Amount <span class="text-red">*</span></label>
                                        <input  oninput="AmountCal()" name="amount[]" type="number" id="amount" value="{{ old('amount') }}" class="form-control amount @error('amount') is-invalid @enderror" placeholder="Enter expense amount" required>

                                        <input name="all_amount" type="number"  id="all_amount" class="form-control" hidden>

                                        @error('amount')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

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
                                        <label for="adjust_bill"> Adjust Bill</label>
                                        <select onchange="addSub()" name="adjust_bill" id="adjust_bill" class="form-control adjust_bill">
                                            <option value="" > Select </option>
                                            <option value="1">Addition</option>
                                            <option value="2">Substraction</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="adjust_amount"> Adjust Amount </label>
                                        <input oninput="calculation()" type="number" name="adjust_amount" id="adjust_amount" value="" class="form-control adjust_amount @error('adjust_amount') is-invalid @enderror" placeholder="Enter adjust amount" required>

                                        @error('adjust_amount')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="total_amount">Total Amount<span class="text-red">*</span></label>
                                        <input type="number" name="total_amount" id="total_amount" value="" class="form-control total_amount" readonly>
                                    </div>
                                </div>
                           </div>

                        <div class="row">
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
                                        <label for="description"> Description </label>
                                        <textarea style="height: 38px" name="description" id="" class="form-control" placeholder="Describe here...">{!! old('description') !!}</textarea>
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
         {{-- <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script> --}}

        <script>
             // date picker
            $(function () {
                $('.datepicker').datepicker({
                    dateFormat: 'dd MM yy'
                });
            });


            // card type multiple field append
        var length = $('#card_type_id > option').length;
        var max = 4;
        var i = 0;
        $("#add").click(function () {
            if( i < max ){
            ++i;
            $("#cardfield").append('<div class="row" id="removerow"><div class="col-sm-4"><div class="form-group"><label for="category_id">Expense-Category<span class="text-red">*</span></label> <select name="category_id[]" id="category_id" class="form-control category_id">  <option value="">Select Expense-Category</option> @foreach ($categories as $key => $value)<option value="{{ $value->id }}">{{ $value->name }}</option> @endforeach</select>@error('category_id')<span class="text-danger" role="alert"><p>{{ $message }}</p></span>@enderror</div></div> <div class="col-sm-4"><div class="form-group"><label for="image"> File Upload </label><input type="file" name="image[]" id="image" value="{{ old('image') }}" class="form-control @error('image') is-invalid @enderror" > @error('image')<span class="text-danger" role="alert"><p>{{ $message }}</p></span>@enderror</div></div><div class="col-sm-3"><div class="form-group"><label for="amount"> Expense Amount <span class="text-red">*</span></label><input name="amount[]" type="number" oninput="ExpenseCal()" id="amount'+i+'" value="{{ old('amount') }}" class="form-control amount @error('amount') is-invalid @enderror" placeholder="Enter expense amount" required>@error('amount') <span class="text-danger" role="alert"><p>{{ $message }}</p></span>@enderror</div> </div><div class="col-sm-1"><div class="form-group"><button style="margin-top: 31px" type="button" name="del" class="btn btn-danger btn_remove">-</button> </div></div></div>');
                }else{
                    alert("You've exhausted all of your options");
                }
            });

            $(document).on('click', '.btn_remove', function() {
                $(this).parents('#removerow').remove();
                i--;

                    var sum = 0;
                        $('.amount').each(function(){
                             sum += parseFloat(this.value);
                        })
                        $('#all_amount').val(sum);

                    var adjust_bill = $('#adjust_bill').val();
                    var adjust_amount = $('#adjust_amount').val();


                    if(adjust_bill == 1){
                     var total =  parseFloat(sum) + parseFloat(adjust_amount) ;
                     $('#total_amount').val(total);

                    }else if(adjust_bill == 2){

                     var total =  parseFloat(sum) - parseFloat(adjust_amount) ;
                     $('#total_amount').val(total);

                    }else{
                        $('#total_amount').val(sum);
                    }
            });

           // bill calculate


                function AmountCal(){

                    var sum = 0;
                        $('.amount').each(function(){
                             sum += parseFloat(this.value);
                        });

                    $('#all_amount').val(sum);

                    var adjust_bill = $('#adjust_bill').val();
                    var adjust_amount = $('#adjust_amount').val();


                    if(adjust_bill == 1){
                     var total =  parseFloat(sum) + parseFloat(adjust_amount) ;
                    $('#total_amount').val(total);

                    }else if(adjust_bill == 2){

                     var total =  parseFloat(sum) - parseFloat(adjust_amount) ;
                    $('#total_amount').val(total);

                    }else{
                        $('#total_amount').val(sum);
                    }
                };

                function calculation(){

                   var sum = 0;
                        $('.amount').each(function(){
                             sum += parseFloat(this.value);
                            console.log(sum);
                        });

                    $('#all_amount').val(sum);

                    var adjust_bill = $('#adjust_bill').val();
                    var adjust_amount = $('#adjust_amount').val();


                    if(adjust_bill == 1){
                     var total =  parseFloat(sum) + parseFloat(adjust_amount) ;
                    $('#total_amount').val(total);

                    }else if(adjust_bill == 2){

                     var total =  parseFloat(sum) - parseFloat(adjust_amount) ;
                    $('#total_amount').val(total);

                    }else{
                        $('#total_amount').val(sum);
                    }
                };

                function addSub(){
                   var sum = 0;
                        $('.amount').each(function(){
                             sum += parseFloat(this.value);
                        });

                        $('#all_amount').val(sum);

                    var adjust_bill = $('#adjust_bill').val();
                    var adjust_amount = $('#adjust_amount').val();


                    if(adjust_bill == 1){
                     var total =  parseFloat(sum) + parseFloat(adjust_amount) ;
                    $('#total_amount').val(total);

                    }else if(adjust_bill == 2){

                     var total =  parseFloat(sum) - parseFloat(adjust_amount) ;
                    $('#total_amount').val(total);

                    }else{
                        $('#total_amount').val(sum);
                    }
                }

                function ExpenseCal(){

                    var sum = 0;
                        $('.amount').each(function(){
                             sum += parseFloat(this.value);
                        });

                        $('#all_amount').val(sum);

                    var adjust_bill = $('#adjust_bill').val();
                    var adjust_amount = $('#adjust_amount').val();


                    if(adjust_bill == 1){
                     var total =  parseFloat(sum) + parseFloat(adjust_amount) ;
                    $('#total_amount').val(total);

                    }else if(adjust_bill == 2){

                     var total =  parseFloat(sum) - parseFloat(adjust_amount) ;
                    $('#total_amount').val(total);

                    }else{
                        $('#total_amount').val(sum);
                    }
                };
        </script>
    @endpush
</x-app-layout>
