<x-app-layout>
    @push('css')

    @endpush
    @section('title', 'Complaint Details')

    <x-slot name="header">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="fas fa-compass"></i>
                </div>
                <div>
                    <h4>Complaint Details</h4>
                </div>
            </div>
            <div class="page-title-actions">
                 <a href="{{ route('admin.complaint.index') }}" type="button" class="btn btn-sm btn-dark">
                    <i class="fas fa-arrow-left mr-1"></i>
                    Back
                </a>
                <a href="{{ route('admin.complaint.create') }}" type="button" class="btn btn-sm btn-info">
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
                                    <th>TIcket ID</th>
                                    <td>{{ $data->ticket_id }}</td>
                                </tr>

                                <tr>
                                    <th>Ticket Type</th>
                                    <td>{{ $data->classifications->name }}</td>
                                </tr>

                                <tr>
                                    <th>Complain Date</th>
                                    <td>{{ $data->complain_date }}</td>
                                </tr>

                                <tr>
                                    <th>Complain Time</th>
                                    <td>{{ $data->complain_time }}</td>
                                </tr>

                                <tr>
                                    <th>Name</th>
                                    <td>{{ $data->name }}</td>
                                </tr>

                                <tr>
                                    <th>Ticket Option</th>
                                    <td>
                                        @if ($data->ticket_option == 1)
                                             Open
                                        @else
                                             Close
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <th>Piority</th>
                                    <td>
                                        @if ($data->piority == 1)
                                             High
                                        @else
                                             Low
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <th>Address</th>
                                    <td>{{ $data->address }}</td>
                                </tr>

                                <tr>
                                    <th>Contact No</th>
                                    <td>{{ $data->contact_no }}</td>
                                </tr>

                                <tr>
                                    <th>Email</th>
                                    <td>{{ $data->email }}</td>
                                </tr>

                                <tr>
                                    <th>Email</th>
                                    <td>{{ $data->operator_name }}</td>
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
