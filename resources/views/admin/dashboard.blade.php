<x-app-layout>

    @section('title', 'Dashboard')

    <x-slot name="header">
        <div class="page-title-wrapper">
            <!-- <h1 class="m-0">Dashboard</h1> -->
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                </div>
                <div>
                    Dashboard
                    <div class="page-title-subheading">
                        This is an example dashboard created using build-in elements and components.
                    </div>
                </div>
            </div>
{{--            <div class="page-title-actions">--}}
{{--                <button type="button" class="btn btn-sm btn-dark">--}}
{{--                    <i class="fas fa-arrow-left mr-1"></i>--}}
{{--                    Back--}}
{{--                </button>--}}
{{--                <button type="button" class="btn btn-sm btn-info">--}}
{{--                    <i class="fas fa-plus mr-1"></i>--}}
{{--                    Create--}}
{{--                </button>--}}
{{--            </div>--}}
        </div><!-- /.page-title-wrapper -->
    </x-slot>

    <!-- Main Content -->

    {{-- <h6>Hello Dashboard</h6> --}}
    <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">

                    <h3>
                        {{-- {{ $complain }} --}}
                    </h3>

                <p>Complaint</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
    </div>



</x-app-layout>
