<x-app-layout>
    @section('title', 'Account Details')
    <x-slot name="header">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="fas fa-compass"></i>
                </div>
                <div>
                    <h4>Account Details</h4>
                </div>
            </div>
            <div class="page-title-actions">
                 <a title="Back Button" href="{{ route('admin.account.index') }}" type="button" class="btn btn-sm btn-dark">
                    <i class="fas fa-arrow-left mr-1"></i>
                    Back
                </a>
                    <a title="Create Button" href="{{ route('admin.account.create') }}" type="button" class="btn btn-sm btn-info">
                        <i class="fas fa-plus mr-1"></i>
                        Create
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
                                    <th> Account Name </th>
                                    <td>{{ $data->name }}</td>
                                </tr>

                                <tr>
                                    <th> Account Type </th>
                                    <td>{{ $data->types->name }}</td>
                                </tr>

                                <tr>
                                    <th>Account No</th>
                                    <td>{{ $data->account_no }}</td>
                                </tr>

                                <tr>
                                    <th>Bank Name</th>
                                    <td>{{ $data->banks->name }}</td>
                                </tr>

                                <tr>
                                    <th>Branch Name</th>
                                    <td>{{ $data->branch_name }}</td>
                                </tr>

                                <tr>
                                    <th>Branch Address</th>
                                    <td>{{ $data->branch_address }}</td>
                                </tr>

                                <tr>
                                    <th>Initial Balance</th>
                                    <td>{{ $data->initial_balance }}</td>
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
</x-app-layout>
