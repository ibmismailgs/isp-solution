<x-app-layout>
    @push('css')

    @endpush
    @section('title', 'Deposit/Withdraw Details')

    <x-slot name="header">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="fas fa-compass"></i>
                </div>
                <div>
                    <h4>Deposit/Withdraw Details</h4>
                </div>
            </div>
            <div class="page-title-actions">
                 <a href="{{ route('admin.transactions.index') }}" type="button" class="btn btn-sm btn-dark">
                    <i class="fas fa-arrow-left mr-1"></i>
                    Back
                </a>
                <a href="{{ route('admin.transactions.create') }}" type="button" class="btn btn-sm btn-info">
                    <i class="fas fa-plus mr-1"></i>
                    Create
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
    </div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <table id="example" class="table table-hover table-bordered ">
                            <thead>

                                <tr>
                                    <th> Account Name </th>
                                    <td>{{ $data->accounts->name }}</td>
                                </tr>

                                <tr>
                                    <th> Account Type </th>
                                    <td>{{ $data->accounts->types->name }}</td>
                                </tr>

                                <tr>
                                    <th> Account No </th>
                                    <td>{{ $data->accounts->account_no }}</td>
                                </tr>

                                <tr>
                                    <th> Transaction Amount (BDT) </th>
                                    <td>{{ $data->transaction_amount }} </td>
                                </tr>

                                <tr>
                                    <th> Bank Name </th>
                                    <td>{{ $data->accounts->banks->name }}</td>
                                </tr>

                                <tr>
                                    <th> Branch Name </th>
                                    <td>{{ $data->accounts->branch_name }}</td>
                                </tr>

                                <tr>
                                    <th>Branch Address</th>
                                    <td>{{ $data->accounts->branch_address }}</td>
                                </tr>

                               <tr>
                                    <th> Payment Method</th>
                                    <td>
                                        @if( $data->payment_type  == 1)
                                            Cash
                                        @elseif($data->payment_type  == 2)
                                            Cheque
                                        @endif
                                    </td>
                                </tr>

                                @if($data->payment_type == 2)
                                <tr>
                                        <th> Cheque Number</th>
                                        <td>{{ $data->cheque_number }}</td>
                                    </tr>
                                @endif

                               <tr>
                                    <th> Purpose </th>
                                    <td>
                                        @if( $data->purpose  == 1)
                                            Expense
                                        @elseif($data->purpose  == 2)
                                            Given Payment
                                        @elseif($data->purpose  == 3)
                                             Received Payment
                                        @elseif($data->purpose  == 4)
                                            Deposit
                                        @endif
                                    </td>
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
    @push('js')

    @endpush
</x-app-layout>
