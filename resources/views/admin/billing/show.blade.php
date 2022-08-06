<x-app-layout>
    @push('css')

    @endpush
    @section('title', "Subscriber's Bill Details")

    <x-slot name="header" id="printableArea">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="fas fa-compass"></i>
                </div>
                <div>
                    <h4>Subscriber's Bill Details</h4>
                </div>
            </div>

            <div class="page-title-actions hidden-print">
                 <a href="{{ route('admin.bill.index') }}" type="button" class="btn btn-sm btn-dark">
                    <i class="fas fa-arrow-left mr-1"></i>
                    Back
                </a>

                 <a href="#" onclick="window.print()" type="button" class="btn btn-sm btn-info">
                   <i class="fa fa-print" aria-hidden="true"></i>
                    Print
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
                                    <th>Subscriber ID</th>
                                    <td>{{ $data->subscribers->subscriber_id }}</td>
                                </tr>

                                <tr>
                                    <th>Name</th>
                                    <td>{{ $data->subscribers->name }}</td>
                                </tr>

                                <tr>
                                    <th>Issue Date</th>
                                    <td>{{ $issueDate }}</td>
                                </tr>

                                <tr>
                                    <th>Area</th>
                                    <td>{{ $data->subscribers->areas->name }} , {{ $data->subscribers->areas->code  }}</td>
                                </tr>

                                <tr>
                                    <th>Address</th>
                                    <td>{{ $data->subscribers->address }}</td>
                                </tr>

                                <tr>
                                    <th>Contact No</th>
                                    <td>{{ $data->subscribers->contact_no }}</td>
                                </tr>

                                <tr>
                                    <th>Category </th>
                                    <td>{{ $data->subscribers->categories->name }}</td>
                                </tr>

                                <tr>
                                    <th>Connection </th>
                                    <td>{{ $data->subscribers->connections->name  }}</td>
                                </tr>

                                <tr>
                                    <th>Package Name</th>
                                    <td>{{ $data->packages->name }}</td>
                                </tr>

                                <tr>
                                    <th>Billing Month</th>
                                    <td>{{ $data->billing_month }}</td>
                                </tr>

                                <tr>
                                    <th>Package Amout</th>
                                    <td>{{ $data->packages->amount }}</td>
                                </tr>

                                <tr>
                                    <th>Used Days </th>
                                    <td>{{ $data->used_day }} days</td>
                                </tr>

                                 <tr>
                                    <th>Extra Add/Sub</th>
                                    <td>
                                        @if( $data->add_sub == 1)
                                            Addition
                                        @elseif($data->add_sub == 2)
                                            Substraction
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <th>Used Amount</th>
                                    <td>{{ $data->used_amount }}</td>
                                </tr>

                                <tr>
                                    <th>Adjust Bill</th>
                                    <td>{{ $data->adjust_bill }}</td>
                                </tr>

                                <tr>
                                    <th>Total Amount</th>
                                    <td>{{ $data->total_amount }}</td>
                                </tr>

                                <tr>
                                    <th>MAC Address</th>
                                    <td>{{ $data->subscribers->mac_address }}</td>
                                </tr>

                                <tr>
                                    <th>IP Address</th>
                                    <td>{{ $data->subscribers->package_id }}</td>
                                </tr>

                                <tr>
                                    <th>Email</th>
                                    <td>{{ $data->subscribers->email }}</td>
                                </tr>

                                <tr>
                                    <th>Bill Status</th>
                                    <td>
                                        @if( $data->status == 1)
                                            Paid
                                        @else
                                            Unpaid
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Description</th>
                                    <td>{{ $data->subscribers->description }}</td>
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
