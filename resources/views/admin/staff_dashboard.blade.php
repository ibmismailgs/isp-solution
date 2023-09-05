<x-app-layout>
    @section('title', 'Staff Dashboard')
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
            <div class="small-box bg-primary">
              <div class="text-center pt-2">
                <h5 class="count-number active-client-data"><b>{{ isset($salary) ? number_format((float)$salary, 2, '.', '') : 0 }} </b> BDT</h5>
                <p>Monthly Salary</p>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-dark">
              <div class="text-center pt-2">
                <h5 class="count-number active-client-data"><b>{{ $designation }}</b></h5>
                <p>Designation</p>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
</x-app-layout>
