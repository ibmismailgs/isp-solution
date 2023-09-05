<x-app-layout>
    @section('title', 'Client Dashboard')
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
        </div>
    </x-slot>

    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
              <div class="text-center pt-2">
                <h5 class="count-number total-complain-data"><b>{{ $complain ?? '--'}}</b></h5>
                <p>Pending Complain</p>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
              <div class="text-center pt-2">
                <h5 class="count-number active-client-data"><b>{{ $area }}</b></h5>
                <p>Area Name</p>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-primary">
              <div class="text-center pt-2">
                <h5 class="count-number active-client-data"><b>{{ $connection }}</b></h5>
                <p>Connection Name</p>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-dark">
              <div class="text-center pt-2">
                <h5 class="count-number total-amount-data"><b>{{ $package }}</b></h5>
                <p> Package Name</p>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-secondary">
              <div class="text-center pt-2">
                <h5 class="count-number total-amount-data"><b>{{ $package_spreed }}</b></h5>
                <p> Package Spreed</p>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
              <div class="text-center pt-2">
                <h5 class="count-number total-paid-data"><b>{{ isset($paid_bill) ? number_format((float)$paid_bill, 2, '.', '') : 0 }}</b> BDT</h5>
                <p>Total Paid Bill</p>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-secondary">
              <div class="text-center pt-2">
                <h5 class="count-number total-due-data"><b>{{ isset($unpaid_bill) ? number_format((float)$unpaid_bill, 2, '.', '') : 0 }}</b> BDT</h5>
                <p>Total Due Bill</p>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
    </div>
</x-app-layout>
