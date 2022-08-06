<x-app-layout>
    @push('css')

    @endpush
    @section('title', 'Client Details')

    <x-slot name="header">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="fas fa-compass"></i>
                </div>
                <div>
                    <h4>Client Details</h4>
                </div>
            </div>
            <div class="page-title-actions">
                 <a href="{{ route('admin.subscriber.index') }}" type="button" class="btn btn-sm btn-dark">
                    <i class="fas fa-arrow-left mr-1"></i>
                    Back
                </a>
                <a href="{{ route('admin.subscriber.create') }}" type="button" class="btn btn-sm btn-info">
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
                                    <th>Client ID</th>
                                    <td>{{ $data->subscriber_id }}</td>
                                </tr>

                                <tr>
                                    <th>Name</th>
                                    <td>{{ $data->name }}</td>
                                </tr>

                                <tr>
                                    <th>Initialize Date</th>
                                    <td>{{ $data->initialize_date }}</td>
                                </tr>

                                <tr>
                                    <th>Birth Date</th>
                                    <td>{{ $data->birth_date }}</td>
                                </tr>

                                <tr>
                                    <th>ID Card Type </th>
                                    @php $cardTypes = json_decode($data->card_type_id);
                                    @endphp
                                    <td>
                                        @foreach($idcards as $key => $idcard)
                                            @if(in_array($idcard->id, $cardTypes))
                                                <span> {{ $idcard->name }} , </span>
                                            @endif
                                        @endforeach
                                    </td>
                                </tr>

                                <tr>
                                    <th>Card Number</th>
                                    @php
                                        $cardNumbers = json_decode($data->card_no);
                                    @endphp
                                    <td>
                                    @foreach($cardNumbers as $cardNumber)
                                        <span> {{ $cardNumber }} ,  </span>
                                    @endforeach
                                    </td>
                                </tr>

                                <tr>
                                    <th>Area</th>
                                    <td>{{ $data->areas->name  }}</td>
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
                                    <th>Client Category </th>
                                    <td>{{ $data->categories->name }}</td>
                                </tr>

                                <tr>
                                    <th>Connection Type</th>
                                    <td>{{ $data->connections->name  }}</td>
                                </tr>

                                <tr>
                                    <th>Package Type</th>
                                    <td>{{ $data->packages->name  }}</td>
                                </tr>

                                <tr>
                                    <th>Device Type</th>
                                    <td>{{ $data->devices->name }}</td>
                                </tr>

                                <tr>
                                    <th>MAC Address</th>
                                    <td>{{ $data->mac_address  }}</td>
                                </tr>

                                <tr>
                                    <th>IP Address</th>
                                    <td>{{ $data->package_id  }}</td>
                                </tr>

                                <tr>
                                    <th>Email</th>
                                    <td>{{ $data->email }}</td>
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
                                    <td>{{ $data->description }}</td>
                                </tr>

                                <tr>
                                    <th>Profile Picture</th>
                                    <td><img height="50px" width="100px" src="{{asset('img/'.$data->image)}}" alt="profile picture missing">
                                    </td>
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
