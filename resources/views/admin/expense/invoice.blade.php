<!doctype html>
    <html lang="en">
    <head>
        <title>Expense Invoice</title>
        <!-- initiate head with meta tags, css and script -->
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="description" content="">
        <meta name="keywords" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>


    <style>
        .card {
            margin-bottom: 1.5rem;
        }
        .card {
            position: relative;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 1px solid #c8ced3;
            border-radius: .25rem;
        }

        .card-header:first-child {
            border-radius: calc(0.25rem - 1px) calc(0.25rem - 1px) 0 0;
        }

        .card-header {
            padding: .75rem 1.25rem;
            margin-bottom: 0;
            background-color: #f0f3f5;
            border-bottom: 1px solid #c8ced3;
        }
        .card-body{
            font-size: 14px;
        }
        .logo{
            height:30px;
            width: 30px;
            border-radius: 50%;
        }
    </style>
    </head>
    <br>
    <body id="app">
        <div class="container-fluid">
            <div id="ui-view" data-select2-id="ui-view">
                <div class="card">
                <div class="card-header"><img class="logo" src="{{asset('logo.png')}}">
                                   Invoice <strong># {{ $data->expense_number }}</strong>
                    {{-- <strong> ISP-Invoice </strong> --}}
                    <a class="btn btn-sm btn-secondary float-right mr-1 d-print-none" href="#" onclick="javascript:window.print();" data-abc="true">
                        <i class="fa fa-print"></i> Print</a>
                        <a class="btn btn-sm btn-info float-right mr-1 d-print-none" href="#" data-abc="true">
                            <i class="fa fa-save"></i> Save</a>
                        </div>
                        <div class="card-body">
                            <div class="row mb-4">
                                <div class="col-sm-4">
                                    <div>
                                        <strong>  </strong>
                                    </div>
                                    <div>Phone: </div>
                                    <div>Email:  </div>
                                    <div>Address: </div>
                                </div>

                                <div class="col-sm-4">
                                    {{-- <div>
                                        <strong>BBBootstrap.com</strong>
                                    </div>
                                    <div>42, Awesome Enclave</div>
                                    <div>New York City, New york, 10394</div>
                                    <div>Email: admin@bbbootstrap.com</div>
                                    <div>Phone: +48 123 456 789</div> --}}
                                </div>

                                <div class="col-sm-4">
                                    {{-- <div> Invoice <strong>#WLT-120</strong> </div> --}}
                                    <div> <strong>{{ $data->date }}</strong> </div>
                                    <div>WLT ISP Service</div>
                                    <div>House# 23/A, Road #3/C</div>
                                    <div>Sector# 9, Uttara-1230</div>
                                </div>

                            </div>

                          <div class="row">
                            <div class="col-12 table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>Subscriber ID</th>
                                        <th>Package Name</th>
                                        <th>Billing Month</th>
                                        <th>Package Amount</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                        <tr>
                                            <td>{{ $data->expense_number }}</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                            <div class="row">
                                <div class="col-lg-4 col-sm-5">
                                <p> Description : </p>

                                <div class="alert alert-secondary mt-20">
                                    <p>{{ $data->description }}</p>
                                </div>
                            </div>

                                <div class="col-lg-4 col-sm-5 ml-auto">
                                    <table class="table table-clear">
                                        <tbody>
                                            <tr>
                                                <td class="left">
                                                    <strong>Subtotal</strong>
                                                </td>
                                                <td class="right">{{ $data->amount }}</td>
                                            </tr>
                                            <tr>
                                                <td class="left">
                                                    <strong>
                                                        @if( $data->adjust_bill == 1)
                                                            Addition
                                                        @else
                                                            Substraction
                                                        @endif
                                                    </strong>
                                                </td>

                                                <td class="right">{{ $data->adjust_amount ?? 0}}</td>
                                            </tr>
                                            {{-- <tr>
                                                <td class="left">
                                                    <strong>VAT (10%)</strong>
                                                </td>
                                                <td class="right">$679,76</td>
                                            </tr> --}}
                                            <tr>
                                                <td class="left">
                                                    <strong>Total</strong>
                                                </td>
                                                <td class="right">
                                                    <strong>{{ $data->total_amount }}</strong>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-2">
                                        ..........................................
                                        <p> Subscriber Signature </p>
                                    </div>
                                    <div class="col-2">
                                        ........................................
                                        <p> Authority Signature </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
             </div>
    </body>
 </html>
