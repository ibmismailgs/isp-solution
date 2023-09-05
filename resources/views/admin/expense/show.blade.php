<x-app-layout>
    @section('title', "Expense Details")
    <x-slot name="header" id="printableArea">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="fas fa-compass"></i>
                </div>
                <div>
                    <h4>Expense Details</h4>
                </div>
            </div>

            <div class="page-title-actions hidden-print">
                 <a title="Back Button" href="{{ route('admin.expense.index') }}" type="button" class="btn btn-sm btn-dark">
                    <i class="fas fa-arrow-left mr-1"></i>
                    Back
                </a>

                 <a title="Print Button" href="#" onclick="window.print()" type="button" class="btn btn-sm btn-info">
                   <i class="fa fa-print" aria-hidden="true"></i>
                    Print
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
    </div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <table id="example" class="table table-hover table-bordered ">
                            <thead>
                                <tr>
                                    <th>Invoice No</th>
                                    <td>{{ $data->expense_number }}</td>
                                </tr>

                                <tr>
                                    <th>Date</th>
                                    <td>{{ $data->date }}</td>
                                </tr>

                                <tr>
                                    <th>Account </th>
                                    <td>{{ $data->accounts->name ?? null }}</td>
                                </tr>

                                <tr>
                                    <th>Expense Type </th>
                                    @php
                                        $categoryTypes = json_decode($data->category_id);
                                    @endphp
                                    <td>
                                        @foreach($categories as $key => $category)
                                            @if(in_array($category->id, $categoryTypes))
                                                <span> {{ $category->name }} , </span>
                                            @endif
                                        @endforeach
                                    </td>
                                </tr>

                                 <tr>
                                    <th>Adjust Bill Type</th>
                                    <td>
                                        @if( $data->adjust_bill == 1)
                                            Additaion
                                        @else
                                            Substraction
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <th> Expense Amount</th>
                                    <td>
                                        @foreach(json_decode($data->amount, true) as $value)
                                            {{ $value }} , &nbsp;
                                        @endforeach
                                    </td>
                                </tr>

                                <tr>
                                    <th> Total Expense</th>

                                    <td> {{ $data->all_amount}}</td>
                                </tr>

                                <tr>
                                    <th>Adjust Amount</th>
                                    <td>{{ $data->adjust_amount }}</td>
                                </tr>

                                <tr>
                                    <th>Total Amount</th>
                                    <td>{{ $data->total_amount }}</td>
                                </tr>

                                <tr>
                                    <th> Status</th>
                                    <td>
                                        @if( $data->status == 1)
                                            Active
                                        @else
                                            Inactive
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <th>Images</th>
                                    <td>
                                        @foreach(json_decode($data->image, true) as $image)
                                            <span > <img height="50px" width="100px" src="{{asset('img/'.$image)}}" alt=""> &nbsp;&nbsp;&nbsp; </span>
                                        @endforeach
                                    </td>
                                </tr>

                                <tr>
                                    <th>Description</th>
                                    <td>{{ $data->description }}</td>
                                </tr>

                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
