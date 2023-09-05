<x-app-layout>
    @section('title', "Staff Details")
    <x-slot name="header" id="printableArea">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="fas fa-compass"></i>
                </div>
                <div>
                    <h4>Staff Details</h4>
                </div>
            </div>

            <div class="page-title-actions hidden-print">
                 <a title="Back Button" href="{{ route('admin.staff.index') }}" type="button" class="btn btn-sm btn-dark">
                    <i class="fas fa-arrow-left mr-1"></i>
                    Back
                </a>

                <a title="Create Button" href="{{ route('admin.staff.create') }}" type="button" class="btn btn-sm btn-info">
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
                        <button title="CLose Button" type="button" class="close" data-dismiss="alert" aria-label="Close">
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
                                    <th>Staff Name</th>
                                    <td>{{ $data->name }}</td>
                                </tr>

                                <tr>
                                    <th>Staff Role</th>
                                    <td>{{ $data->roles->name }}</td>
                                </tr>

                                <tr>
                                    <th>Date Of Birth</th>
                                    <td>{{ $data->birth_date }}</td>
                                </tr>

                                <tr>
                                    <th>Join Date</th>
                                    <td>{{  $data->join_date }}</td>
                                </tr>

                                 <tr>
                                    <th>Gender</th>
                                    <td>
                                        @if( $data->gender == 1)
                                            Male
                                        @elseif($data->gender == 2)
                                            Female
                                        @else
                                            Other
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <th> Designation</th>
                                    <td>{{$data->designation}}</td>
                                </tr>

                                <tr>
                                    <th>Salary</th>
                                    <td> {{ $data->salary}}</td>
                                </tr>

                                <tr>
                                    <th>Contact</th>
                                    <td>{{ $data->contact_no }}</td>
                                </tr>

                                <tr>
                                    <th>Email</th>
                                    <td>{{ $data->email }}</td>
                                </tr>

                                <tr>
                                    <th>Address</th>
                                    <td>{{ $data->address }}</td>
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
                                    <td><img title="Image" height="50px" width="100px" src="{{asset('img/'.$data->image)}}" alt="">
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
