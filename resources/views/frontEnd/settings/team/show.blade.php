<x-app-layout>
    @section('title', 'Team Details')
    <x-slot name="header">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="fas fa-compass"></i>
                </div>
                <div>
                    <h4>Team Details</h4>
                </div>
            </div>
            <div class="page-title-actions">
                 <a title="Back Button" href="{{ route('admin.team-setting.index') }}" type="button" class="btn btn-sm btn-dark">
                    <i class="fas fa-arrow-left mr-1"></i>
                    Back
                </a>

                <a title="Create Button" href="{{ route('admin.team-setting.create') }}" type="button" class="btn btn-sm btn-info">
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
                        <table id="example" class="table table-hover table-bordered ">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <td>{{ $data->name }}</td>
                                </tr>

                                <tr>
                                    <th>Designation</th>
                                    <td>{{ $data->designation }}</td>
                                </tr>

                                <tr>
                                    <th>Phone</th>
                                    <td>{{ $data->phone }}</td>
                                </tr>

                                <tr>
                                    <th>Email</th>
                                    <td>{{ $data->email }}</td>
                                </tr>

                                <tr>
                                    <th>Facebook</th>
                                    <td>{{ $data->facebook }}</td>
                                </tr>

                                <tr>
                                    <th>Instagram</th>
                                    <td>{{ $data->instagram }}</td>
                                </tr>

                                <tr>
                                    <th>Twitter</th>
                                    <td>{{ $data->twitter }}</td>
                                </tr>

                                <tr>
                                    <th>LinkedIn</th>
                                    <td>{{ $data->linkedin }}</td>
                                </tr>

                                <tr>
                                    <th>Address</th>
                                    <td>{{ $data->address }}</td>
                                </tr>

                                <tr>
                                    <th>Status</th>
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
                                    <td>{{ $data->description ?? '--'}}</td>
                                </tr>

                                <tr>
                                    <th>Profile Picture</th>
                                    <td><img height="50px" width="100px" src="{{asset('img/'.$data->profile_picture)}}" alt="profile picture">
                                    </td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
