<x-app-layout>
    @section('title', "Client's Billing History")
    <x-slot name="header" id="printableArea">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="fas fa-compass"></i>
                </div>
                <div>
                    <h5>Billing History of <b> {{  $data->subscribers->name }} </b></h5>
                </div>
            </div>

            <div class="page-title-actions hidden-print">
                 <a title="Back Button" href="{{ route('admin.client-dashboard.index') }}" type="button" class="btn btn-sm btn-dark">
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
                                <th>SN</th>
                                <th>Billing Month</th>
                                <th>Packages</th>
                                <th>Package Spreed</th>
                                <th>Connections </th>
                                <th>Status</th>
                                <th>Amount</th>
                            </tr>
                            </thead>

                            <tbody>
                                @foreach($details as $key => $item)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{ $item->billing_month }}</td>
                                    <td>{{ $item->packages->name }}</td>
                                    <td>{{ $item->packages->package_spreed }}</td>
                                    <td>{{ $item->subscribers->connections->name  }}</td>
                                    <td>
                                        @if( $item->status == 1)
                                            Paid
                                        @else
                                            Unpaid
                                        @endif
                                    </td>
                                    <td>{{ $item->total_amount }}</td>
                                </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
