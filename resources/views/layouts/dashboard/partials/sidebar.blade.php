<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{url('/')}}" class="brand-link">
        <img src="{{asset('logo.png')}}" alt="Professional Dashboard" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">Dashboard</span>
    </a>

    @php
        $prefix = Request::route()->getPrefix();
        $route  = Route::current()->getName();
    @endphp

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav>
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                    with font-awesome or any other icon font library -->
                <li class="nav-item menu-open">
                    <a href="{{url('/')}}" class="nav-link dashboard-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                {{-- <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chart-pie"></i>
                        <p>Blank</p>
                    </a>
                </li> --}}
                <li class="nav-item {{ ($route == 'admin.area.index' || $route == 'admin.connection.index' || $route == 'admin.package.index' || $route == 'admin.identity.index' || $route == 'admin.device.index' || $route == 'admin.staff.index')  ? 'menu-open' : ' ' }}">
                    <a href="#" class="nav-link">
                        <i class="fas fa-tools"></i>
                        <p class="ml-2">Settings <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.area.index')}}" class="nav-link {{ ( $route == 'admin.area.index') ? 'dashboard-link' : ' ' }}">
                                <p class="nav-link-p-nasted">
                                <i class="fas fa-map-marker-alt nav-icon"></i> Area</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.connection.index')}}" class="nav-link {{ ( $route == 'admin.connection.index') ? 'dashboard-link' : ' ' }}">
                                <p class="nav-link-p-nasted">  <i class="fas fa-wifi nav-icon "></i> Connection</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.package.index')}}" class="nav-link {{ ( $route == 'admin.package.index') ? 'dashboard-link' : ' ' }}">
                                <p class="nav-link-p-nasted">  <i class="fas fa-network-wired nav-icon"></i> Packages</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route ('admin.identity.index')}}" class="nav-link {{ ( $route == 'admin.identity.index') ? 'dashboard-link' : ' ' }}">
                                <p class="nav-link-p-nasted">  <i class="fas fa-id-card"></i>  ID Card Type </p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route ('admin.device.index')}}" class="nav-link {{ ( $route == 'admin.device.index') ? 'dashboard-link' : ' ' }}">
                                <p class="nav-link-p-nasted">  <i class="fa fa-laptop"></i> Device Type</p>
                            </a>
                        </li>
                    </ul>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route ('admin.staff.index')}}" class="nav-link {{ ( $route == 'admin.staff.index') ? 'dashboard-link' : ' ' }}">
                                <p class="nav-link-p-nasted">  <i class="fa fa-users"></i> Staff </p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item {{ ($route == 'admin.subscriber-category.index' || $route == 'admin.subscriber.index' || $route == 'admin.client-dashboard.index') ? 'menu-open' : ' ' }}">
                    <a href="#" class="nav-link ">
                        <i class="nav-icon fas fa-user-cog"></i>
                        <p class="ml-2">Client <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.subscriber-category.index')}}" class="nav-link {{ ( $route == 'admin.subscriber-category.index') ? 'dashboard-link' : ' ' }}">
                                <p class="nav-link-p-nasted">  <i class="fas fa-layer-group nav-iconCategory"></i> Client Category</p>
                            </a>
                        </li>
                    </ul>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.subscriber.index')}}" class="nav-link {{ ( $route == 'admin.subscriber.index') ? 'dashboard-link' : ' ' }}">
                                <p class="nav-link-p-nasted"><i class="nav-icon fas fa-user-cog"></i> Client </p>
                            </a>
                        </li>
                    </ul>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.client-dashboard.index')}}" class="nav-link {{ ( $route == 'admin.client-dashboard.index') ? 'dashboard-link' : ' ' }}">
                                <p class="nav-link-p-nasted"><i class="nav-icon fas fa-user-cog"></i> Client Dashboard</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item {{ ($route == 'admin.bill.index' || $route == 'admin.bill-list' || $route == 'admin.paid-client' || $route == 'admin.unpaid-client') ? 'menu-open' : ' ' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-receipt"></i>
                        <p class="ml-2">Billing <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.bill.index')}}" class="nav-link {{ ( $route == 'admin.bill.index') ? 'dashboard-link' : ' ' }}">
                                <p class="nav-link-p-nasted">  <i class="fas fa-sync-alt nav-icon"></i> Billing Process</p>
                            </a>
                        </li>
                    </ul>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.bill-list')}}" class="nav-link {{ ( $route == 'admin.bill-list') ? 'dashboard-link' : ' ' }}">
                                <p class="nav-link-p-nasted">  <i class="fas fa fa-list nav-icon"></i> Bill List</p>
                            </a>
                        </li>
                    </ul>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.subscriber.index')}}" class="nav-link">
                                <p class="nav-link-p-nasted"><i class="fas fa-money-bill-alt nav-icon"></i> Bill Payment </p>
                            </a>
                        </li>
                    </ul>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.paid-client')}}" class="nav-link {{ ( $route == 'admin.paid-client') ? 'dashboard-link' : ' ' }}">
                                <p class="nav-link-p-nasted"><i class="nav-icon fas fa-user-cog"></i> Paid Cients </p>
                            </a>
                        </li>
                    </ul>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.unpaid-client')}}" class="nav-link {{ ( $route == 'admin.unpaid-client') ? 'dashboard-link' : ' ' }}">
                                <p class="nav-link-p-nasted"><i class="nav-icon fas fa-user-cog"></i> Un-Paid Cients </p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item {{ ($route == 'admin.classification.index' || $route == 'admin.complaint.index')  ? 'menu-open' : ' ' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-file-signature"></i>
                        <p class="ml-2"> Complaint <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.classification.index')}}" class="nav-link {{ ( $route == 'admin.classification.index') ? 'dashboard-link' : ' ' }}">
                                <p class="nav-link-p-nasted">  <i class="fas fa-map-marker-alt nav-icon"></i> Classification</p>
                            </a>
                        </li>
                    </ul>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.complaint.index')}}" class="nav-link {{ ( $route == 'admin.complaint.index') ? 'dashboard-link' : ' ' }}">
                                <p class="nav-link-p-nasted"><i class="fas fa-street-view nav-icon"></i> Complaint </p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item {{ ($route == 'admin.request-area-list' || $route == 'admin.request-connection-list' || $route == 'admin.request-package-list')  ? 'menu-open' : ' ' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-envelope"></i>
                        <p class="ml-2"> Notification <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <p class="nav-link-p-nasted">  <i class="fas fa-envelope-open-text nav-icon"></i> Email Notification</p>
                            </a>
                        </li>
                    </ul>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" class="nav-link ">
                                <p class="nav-link-p-nasted"><i class="fas fa-comment-alt nav-icon"></i> SMS Notification</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.request-area-list') }}" class="nav-link {{ ( $route == 'admin.request-area-list') ? 'dashboard-link' : ' ' }}">
                                <p class="nav-link-p-nasted"><i class="fas fa-map-marker-alt nav-icon"></i> Request Area </p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.request-connection-list') }}" class="nav-link {{ ( $route == 'admin.request-connection-list') ? 'dashboard-link' : ' ' }}">
                                <p class="nav-link-p-nasted"><i class="fas fa-wifi nav-icon"></i> Request Connection </p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.request-package-list') }}" class="nav-link {{ ( $route == 'admin.request-package-list') ? 'dashboard-link' : ' ' }}">
                                <p class="nav-link-p-nasted"><i class="fas fa-network-wired nav-icon"></i> Request Package</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item {{ ($route == 'admin.bank.index' || $route == 'admin.account-type.index' || $route == 'admin.account.index' || $route == 'admin.transactions.index' || $route == 'admin.balance' || $route == 'admin.account-statement')  ? 'menu-open' : ' ' }}">
                    <a href="#" class="nav-link">
                        <i class="fas fa-users nav-icon"></i>
                        <p class="ml-2"> Account <i class="right fas fa-angle-left"></i></p>
                    </a>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.bank.index')}}" class="nav-link {{ ( $route == 'admin.bank.index' ) ? 'dashboard-link' : '' }}">
                                <p class="nav-link-p-nasted"> <i class='fas fa-landmark nav-icon'></i> Banks</p>
                            </a>
                        </li>
                    </ul>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.account-type.index')}}" class="nav-link {{ ( $route == 'admin.account-type.index' ) ? 'dashboard-link' : '' }}">
                                <p class="nav-link-p-nasted">  <i class="fas fa-users nav-icon"></i> Account Type</p>
                            </a>
                        </li>
                    </ul>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.account.index')}}" class="nav-link {{ ( $route == 'admin.account.index' ) ? 'dashboard-link' : '' }}">
                                <p class="nav-link-p-nasted">  <i class="fas fa-users nav-icon"></i> Accounts</p>
                            </a>
                        </li>
                    </ul>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.transactions.index')}}" class="nav-link {{ ( $route == 'admin.transactions.index' ) ? 'dashboard-link' : '' }}">
                                <p class="nav-link-p-nasted">  <i class="fas fa-exchange-alt nav-icon"></i> Deposit/Withdraw</p>
                            </a>
                        </li>
                    </ul>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.balance')}}" class="nav-link {{ ( $route == 'admin.balance' ) ? 'dashboard-link' : '' }}">
                                <p class="nav-link-p-nasted">  <i class="fas fa-users nav-icon"></i> Balance Sheet</p>
                            </a>
                        </li>
                    </ul>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.account-statement')}}" class="nav-link {{ ( $route == 'admin.account-statement' ) ? 'dashboard-link' : '' }}">
                                <p class="nav-link-p-nasted">  <i class="fas fa-users nav-icon"></i> Accounts Statement</p>
                            </a>
                        </li>
                    </ul>

                </li>

                <li class="nav-item {{ ( $route == 'admin.expense-category.index' || $route == 'admin.expense.index' ) ? 'menu-open' : ' ' }}">
                    <a href="#" class="nav-link">
                        {{-- <i class="fas fa-hand-holding-usd nav-icon"></i> --}}
                        <i class="fas fa-minus-circle nav-icon"></i>
                        <p class="ml-2"> Expense <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.expense-category.index')}}" class="nav-link  {{ ( $route == 'admin.expense-category.index' ) ? 'dashboard-link' : '' }}">
                                <p class="nav-link-p-nasted">  <i class="fas fa-hand-holding-usd nav-icon"></i> Expense Category</p>
                            </a>
                        </li>
                    </ul>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.expense.index')}}" class="nav-link {{ ( $route == 'admin.expense.index' ) ? 'dashboard-link' : '' }}">
                                <p class="nav-link-p-nasted">  <i class="fas fa-hand-holding-usd nav-icon"></i> Expenses</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item {{ ( $route == 'admin.subscriber-list' || $route == 'admin.report-package' || $route == 'admin.report-connection' || $route == 'admin.report-area' || $route == 'admin.report-category' || $route == 'admin.report-device') ? 'menu-open' : ' ' }}">
                    <a href="#" class="nav-link">
                        <i class="fas fa-file nav-icon"></i>
                        <p class="ml-2"> Report <i class="right fas fa-angle-left"></i></p>
                    </a>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.subscriber-list')}}" class="nav-link {{ ( $route == 'admin.subscriber-list' ) ? 'dashboard-link' : '' }}">
                                <p class="nav-link-p-nasted"> <i class="nav-icon fas fa-user-cog nav-icon"></i> Clients </p>
                            </a>
                        </li>
                    </ul>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.report-area')}}" class="nav-link {{ ( $route == 'admin.report-area' ) ? 'dashboard-link' : '' }}">
                                <p class="nav-link-p-nasted"> <i class="nav-icon fas fa-user-cog nav-icon"></i> Areas </p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.report-connection')}}" class="nav-link {{ ( $route == 'admin.report-connection' ) ? 'dashboard-link' : '' }}">
                                <p class="nav-link-p-nasted"> <i class="nav-icon fas fa-user-cog nav-icon"></i> Connections </p>
                            </a>
                        </li>
                    </ul>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.report-package')}}" class="nav-link {{ ( $route == 'admin.report-package' ) ? 'dashboard-link' : '' }}">
                                <p class="nav-link-p-nasted"> <i class="nav-icon fas fa-user-cog nav-icon"></i> Packages </p>
                            </a>
                        </li>
                    </ul>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.report-device')}}" class="nav-link {{ ( $route == 'admin.report-device' ) ? 'dashboard-link' : '' }}">
                                <p class="nav-link-p-nasted"> <i class="nav-icon fas fa-user-cog nav-icon"></i> Devices </p>
                            </a>
                        </li>
                    </ul>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.report-category')}}" class="nav-link {{ ( $route == 'admin.report-category' ) ? 'dashboard-link' : '' }}">
                                <p class="nav-link-p-nasted"> <i class="nav-icon fas fa-user-cog nav-icon"></i> Client Categories </p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}" class="nav-link">
                        @csrf
                        <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                this.closest('form').submit();">
                            <i class="fas fa-sign-out-alt"></i>
                            {{ __('Log Out') }}
                        </a>
                    </form>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
