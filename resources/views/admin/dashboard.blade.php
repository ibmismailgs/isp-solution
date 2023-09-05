<x-app-layout>
    @section('title', 'Dashboard')
    <x-slot name="header">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                </div>
                <div>
                    Welcome <b>{{Auth::user()->name}}</b>
                    <div class="page-title-subheading">
                       Internet Service Provider (ISP)
                    </div>
                </div>
            </div>

            @if ((Auth::user()->type) == 1)
             @can('admin_dashboard')
                <div class="filter-toggle btn-group page-title-actions">

                    <button title="Button" style="border-top-left-radius: 15px; border-bottom-left-radius: 15px;" class="btn btn-secondary date-btn" data-start_date="{{date('Y-m-d')}}" data-end_date="{{date('Y-m-d')}}">Today</button>

                    <button title="Button" class="btn btn-secondary date-btn" data-start_date="{{date('Y-m-d', strtotime(' -7 day'))}}" data-end_date="{{date('Y-m-d')}}">Last 7 Days</button>

                    <button title="Button" class="btn btn-secondary date-btn active" data-start_date="{{date('Y').'-'.date('m').'-'.'01'}}" data-end_date="{{date('Y-m-d')}}">This Month</button>

                    <button title="Button" class="btn btn-secondary date-btn" data-start_date="{{date('Y-m', strtotime(' -1 month'))}}" data-end_date="{{date('Y-m')}}">Last Month</button>

                    <button title="Button" class="btn btn-secondary date-btn" data-start_date="{{date('Y-m', strtotime(' -3 month'))}}" data-end_date="{{date('Y-m')}}">Last 3 Months</button>

                    <button title="Button" class="btn btn-secondary date-btn" data-start_date="{{date('Y-m', strtotime(' -6 month'))}}" data-end_date="{{date('Y-m')}}">Last 6 Months</button>

                    <button title="Button" style="border-top-right-radius: 15px; border-bottom-right-radius: 15px;" class="btn btn-secondary date-btn" data-start_date="{{date('Y').'-01'.'-01'}}" data-end_date="{{date('Y').'-12'.'-31'}}">This Year</button>
                </div>
            @endcan
            @endif
        </div>
    </x-slot>

    <div class="row">
         @can('admin_dashboard')
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
              <div class="text-center pt-1">
                <h3 class="count-number total-complain-data">{{ isset($complain) ? $complain : 0 }}</h3>
                <p>Pending Complain</p>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-primary">
              <div class="text-center pt-1">
                <h3 class="count-number total-client-data">{{ isset($total_client) ? $total_client : 0 }}</h3>
                <p>Total Client</p>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
              <div class="text-center pt-1">
                <h3 class="count-number active-client-data">{{ isset($total_active_client) ? $total_active_client : 0 }}</h3>
                <p>Total Active Client</p>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-secondary">
              <div class="text-center pt-1">
                <h3 class="count-number active-client-data">{{ isset($total_staff) ? $total_staff : 0 }}</h3>
                <p>Total Staff</p>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>


        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
              <div class="text-center pt-1">
                <h3 class="count-number total-paid-data">{{ isset($paid_bill) ? number_format((float)$paid_bill, 2, '.', ''): 0 }}</h3>
                <p>Total Paid Bill</p>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-secondary">
              <div class="text-center pt-1">
                <h3 class="count-number total-due-data">{{ isset($unpaid_bill) ? number_format((float)$unpaid_bill, 2, '.', ''): 0 }}</h3>
                <p>Total Due Bill</p>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
              <div class="text-center pt-1">
                <h3 class="count-number total-expense-data">{{ isset($total_expense) ? number_format((float)$total_expense, 2, '.', ''): 0 }}</h3>
                <p>Total Expense</p>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-lg-3 col-6">
            <div class="small-box bg-dark">
              <div class="text-center pt-1">
                <h3 class="count-number total-amount-data">{{ isset($total_amount) ? number_format((float)$total_amount, 2, '.', ''): 0 }}</h3>
                <p>Total Amount</p>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

          @endcan
    </div>

    @push('js')
    <script>
            $(".date-btn").on("click", function() {
                $(".date-btn").removeClass("active");
                $(this).addClass("active");
                var start_date = $(this).data('start_date');
                var end_date = $(this).data('end_date');
                $.get('admin/dashboard-filter/' + start_date + '/' + end_date, function(data) {
                    dashboardFilter(data);
                });
            });

            function dashboardFilter(data){
                $('.total-complain-data').hide();
                $('.total-complain-data').html(parseInt(data[0]));
                $('.total-complain-data').show(500);

                $('.total-client-data').hide();
                $('.total-client-data').html(parseInt(data[1]));
                $('.total-client-data').show(500);

                $('.active-client-data').hide();
                $('.active-client-data').html(parseFloat(data[2]));
                $('.active-client-data').show(500);

                $('.total-amount-data').hide();
                $('.total-amount-data').html(parseFloat(data[3]).toFixed(2));
                $('.total-amount-data').show(500);

                $('.total-paid-data').hide();
                $('.total-paid-data').html(parseFloat(data[4]).toFixed(2));
                $('.total-paid-data').show(500);

                $('.total-due-data').hide();
                $('.total-due-data').html(parseFloat(data[5]).toFixed(2));
                $('.total-due-data').show(500);

                $('.total-expense-data').hide();
                $('.total-expense-data').html(parseFloat(data[6]).toFixed(2));
                $('.total-expense-data').show(500);
            }
    </script>
    @endpush
</x-app-layout>
