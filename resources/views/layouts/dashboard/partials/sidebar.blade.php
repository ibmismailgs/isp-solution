<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{url('/')}}" class="brand-link">
        <?php
            $generalSettings= App\Models\Admin\Settings\GeneralSetting::first();
        ?>
        <img src="@isset($generalSettings) {{ asset('img/' . $generalSettings->favicon) }} @endisset" alt="Company Logo" class="brand-image img-circle elevation-3"
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
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <li class="nav-item {{ ( $route == 'admin.banner-setting' || $route == 'admin.about-setting' || $route == 'admin.service-setting.index' || $route == 'admin.service-setting.create' || $route == 'admin.service-setting.edit' || $route == 'admin.team-setting.index' || $route == 'admin.team-setting.create' || $route == 'admin.team-setting.edit' || $route == 'admin.team-setting.show' || $route == 'admin.team-color-setting' || $route == 'admin.faq-setting.index' || $route == 'admin.faq-setting.create' || $route == 'admin.faq-setting.edit' || $route == 'admin.social-link' || $route == 'admin.message-list' || $route == 'admin.general-settings' || $route == 'admin.service-color-setting' || $route == 'admin.faq-color-setting' || $route == 'admin.package-color-setting') ? 'menu-open' : ' ' }}">
                    @can('access_to_expense')
                    <a title="Frontend Settings" href="#" class="nav-link">
                        <i class="fas fa-home nav-icon"></i>
                        <p class="ml-2">Frontend Settings<i class="right fas fa-angle-left"></i></p>
                    </a>
                    @endcan

                    @can('access_to_area')
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a title="General Settings" href="{{route('admin.general-settings')}}" class="nav-link {{ ( $route == 'admin.general-settings' || $route == 'admin.general-settings' || $route == 'admin.general-settings') ? 'dashboard-link' : ' ' }}">
                                <p class="nav-link-p-nasted">
                                <i class="fa fa-cog"></i> General Settings</p>
                            </a>
                        </li>
                    </ul>
                    @endcan

                    @can('access_to_expense_category')
                    <ul class="nav nav-treeview">
                        <li class="nav-item">

                            <a title="Banner Settings" href="{{route('admin.banner-setting')}}" class="nav-link  {{ ( $route == 'admin.banner-setting') ? 'dashboard-link' : '' }}">
                                <p class="nav-link-p-nasted"><i class="fas fa-image nav-icon"></i>Banner</p>
                            </a>

                            <a title="About Setting" href="{{route('admin.about-setting')}}" class="nav-link {{ ( $route == 'admin.about-setting' || $route == 'admin.about-setting') ? 'dashboard-link' : '' }}">
                                <p class="nav-link-p-nasted"><i class="fas fa-info-circle nav-icon"></i>About</p>
                            </a>

                            <a title="About Setting" href="{{route('admin.package-color-setting')}}" class="nav-link {{ ( $route == 'admin.package-color-setting') ? 'dashboard-link' : '' }}">
                                <p class="nav-link-p-nasted"><i class="fas fa-gift nav-icon"></i>Package Color</p>
                            </a>

                            <li class="nav-item {{ ( $route == 'admin.service-color-setting' || $route == 'admin.service-setting.index' || $route == 'admin.service-setting.create' || $route == 'admin.service-setting.edit') ? 'menu-open' : ' ' }}">
                                <a title="Sevice" href="#" class="nav-link " >
                                   <i class="fa fa-wrench" aria-hidden="true"></i>
                                    <p class="ml-2">Sevices<i class="right fas fa-angle-left"></i></p>
                                </a>

                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a title="Sevice Color" href="{{route('admin.service-color-setting')}}" class="nav-link {{ ( $route == 'admin.service-color-setting') ? 'dashboard-link' : '' }}">
                                            <p class="nav-link-p-nasted"><i class="fas fa-wrench nav-icon"></i>Sevice Color</p>
                                        </a>

                                        <a title="Sevice Settings" href="{{route('admin.service-setting.index')}}" class="nav-link {{ ( $route == 'admin.service-setting.index' || $route == 'admin.service-setting.create' || $route == 'admin.service-setting.edit') ? 'dashboard-link' : '' }}">
                                            <p class="nav-link-p-nasted"><i class="fas fa-wrench nav-icon"></i>Sevice Content</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item {{ ( $route == 'admin.team-setting.index' || $route == 'admin.team-setting.create' || $route == 'admin.team-setting.edit' || $route == 'admin.team-setting.show'|| $route == 'admin.team-color-setting') ? 'menu-open' : ' ' }}">
                                <a title="Sevice" href="#" class="nav-link " >
                                   <i class="fa fa-users" aria-hidden="true"></i>
                                    <p class="ml-2">Team<i class="right fas fa-angle-left"></i></p>
                                </a>

                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a title="Sevice Color" href="{{route('admin.team-color-setting')}}" class="nav-link {{ ( $route == 'admin.team-color-setting') ? 'dashboard-link' : '' }}">
                                            <p class="nav-link-p-nasted"><i class="fas fa-wrench nav-icon"></i>Color Change</p>
                                        </a>

                                        <a title="Team Settings" href="{{route('admin.team-setting.index')}}" class="nav-link {{ ($route == 'admin.team-setting.index' || $route == 'admin.team-setting.create' || $route == 'admin.team-setting.edit' || $route == 'admin.team-setting.show') ? 'dashboard-link' : '' }}">
                                            <p class="nav-link-p-nasted"><i class="fas fa-users nav-icon"></i>Team Content</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item {{ ( $route == 'admin.faq-setting.index' || $route == 'admin.faq-setting.create' || $route == 'admin.faq-setting.edit' || $route == 'admin.faq-color-setting') ? 'menu-open' : ' ' }}">
                                <a title="Sevice" href="#" class="nav-link " >
                                    <i class="fas fa-question-circle nav-icon"></i>
                                    <p class="ml-2">Faq<i class="right fas fa-angle-left"></i></p>
                                </a>

                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a title="Sevice Color" href="{{route('admin.faq-color-setting')}}" class="nav-link {{ ( $route == 'admin.faq-color-setting') ? 'dashboard-link' : '' }}">
                                            <p class="nav-link-p-nasted"><i class="fas fa-wrench nav-icon"></i>Color Change</p>
                                        </a>

                                        <a title="Faq Settings" href="{{route('admin.faq-setting.index')}}" class="nav-link {{ ($route == 'admin.faq-setting.index' || $route == 'admin.faq-setting.create' || $route == 'admin.faq-setting.edit') ? 'dashboard-link' : '' }}">
                                            <p class="nav-link-p-nasted"><i class="fas fa-question-circle nav-icon"></i>Faq Content</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item">
                                <a title="Social Link" href="{{route('admin.social-link')}}" class="nav-link {{ ( $route == 'admin.social-link') ? 'dashboard-link' : '' }}">
                                    <p class="nav-link-p-nasted"><i class="fab fa-facebook-f nav-icon"></i>Social Media</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a title="Message" href="{{route('admin.message-list')}}" class="nav-link {{ ( $route == 'admin.message-list') ? 'dashboard-link' : '' }}">
                                <p class="nav-link-p-nasted"><i class="fa fa-envelope" aria-hidden="true"></i> Messages</p>
                                </a>
                            </li>
                        </li>
                    </ul>
                    @endcan
                </li>

                <li class="nav-item {{ ($route == 'admin.area.index' || $route == 'admin.area.create' || $route == 'admin.area.edit' || $route == 'admin.connection.index' ||  $route == 'admin.connection.edit' || $route == 'admin.connection.create' || $route == 'admin.package.index' || $route == 'admin.package.create' || $route == 'admin.package.edit' || $route == 'admin.identity.index' || $route == 'admin.identity.create' || $route == 'admin.identity.edit' || $route == 'admin.device.index' || $route == 'admin.device.create' || $route == 'admin.device.edit' || $route == 'admin.bank.index' || $route == 'admin.bank.create' || $route == 'admin.bank.edit' || $route == 'admin.account-type.index' || $route == 'admin.account-type.create' || $route == 'admin.account-type.edit' || $route == 'admin.account.index' || $route == 'admin.account.create' || $route == 'admin.account.edit' || $route == 'admin.account.show' )  ? 'menu-open' : ' ' }}">
                    @can('access_to_setting')
                    <a href="#" class="nav-link" title="Settings">
                        <i class="fas fa-cog"></i>
                        <p class="ml-2">Settings<i class="right fas fa-angle-left"></i></p>
                    </a>
                    @endcan

                    @can('access_to_area')
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a title="Area" href="{{route('admin.area.index')}}" class="nav-link {{ ( $route == 'admin.area.index' || $route == 'admin.area.create' || $route == 'admin.area.edit') ? 'dashboard-link' : ' ' }}">
                                <p class="nav-link-p-nasted">
                                <i class="fas fa-map-marker-alt nav-icon"></i>Area</p>
                            </a>
                        </li>
                    </ul>
                    @endcan

                    @can('access_to_connection')
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a title="Connection" href="{{route('admin.connection.index')}}" class="nav-link {{ ( $route == 'admin.connection.index' || $route == 'admin.connection.edit' || $route == 'admin.connection.create') ? 'dashboard-link' : ' ' }}">
                                <p class="nav-link-p-nasted"><i class="fas fa-wifi nav-icon "></i>Connection</p>
                            </a>
                        </li>
                    </ul>
                    @endcan

                    @can('access_to_package')
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a title="Packages" href="{{route('admin.package.index')}}" class="nav-link {{ ( $route == 'admin.package.index' || $route == 'admin.package.create' || $route == 'admin.package.edit') ? 'dashboard-link' : ' ' }}">
                                <p class="nav-link-p-nasted"><i class="fas fa-network-wired nav-icon"></i>Packages</p>
                            </a>
                        </li>
                    </ul>
                    @endcan

                    @can('access_to_idcard')
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a title="ID Card Type" href="{{route ('admin.identity.index')}}" class="nav-link {{ ( $route == 'admin.identity.index' || $route == 'admin.identity.create' || $route == 'admin.identity.edit') ? 'dashboard-link' : ' ' }}">
                                <p class="nav-link-p-nasted"><i class="fas fa-id-card"></i> ID Card Type</p>
                            </a>
                        </li>
                    </ul>
                    @endcan

                    @can('access_to_device')
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a title="Device Type" href="{{route ('admin.device.index')}}" class="nav-link {{ ( $route == 'admin.device.index' || $route == 'admin.device.create' || $route == 'admin.device.edit') ? 'dashboard-link' : ' ' }}">
                                <p class="nav-link-p-nasted"><i class="fa fa-laptop"></i> Device Type</p>
                            </a>
                        </li>
                    </ul>
                    @endcan

                    @can('access_to_bank')
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.bank.index')}}" class="nav-link {{ ( $route == 'admin.bank.index' || $route == 'admin.bank.create' || $route == 'admin.bank.edit') ? 'dashboard-link' : '' }}">
                                <p class="nav-link-p-nasted"><i class='fas fa-landmark nav-icon'></i>Banks</p>
                            </a>
                        </li>
                    </ul>
                    @endcan

                    @can('access_to_bank')
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a title="Account Type" href="{{route('admin.account-type.index')}}" class="nav-link {{ ( $route == 'admin.account-type.index' || $route == 'admin.account-type.create' || $route == 'admin.account-type.edit') ? 'dashboard-link' : '' }}">
                                <p class="nav-link-p-nasted"><i class="fas fa-users nav-icon"></i>Account Type</p>
                            </a>
                        </li>
                    </ul>
                    @endcan

                    @can('access_to_bank')
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a title="Accounts" href="{{route('admin.account.index')}}" class="nav-link {{ ( $route == 'admin.account.index' || $route == 'admin.account.create' || $route == 'admin.account.edit' || $route == 'admin.account.show') ? 'dashboard-link' : '' }}">
                                <p class="nav-link-p-nasted"><i class="fas fa-users nav-icon"></i>Accounts</p>
                            </a>
                        </li>
                    </ul>
                    @endcan

                </li>

                <li class="nav-item {{ ($route == 'admin.subscriber-category.index' || $route == 'admin.subscriber-category.create' || $route == 'admin.subscriber-category.edit' || $route == 'admin.subscriber.index' || $route == 'admin.subscriber.edit' || $route == 'admin.subscriber.create' || $route == 'admin.client-dashboard.index' || $route == 'admin.client-dashboard.show' || $route == 'admin.billing-history' || $route == 'admin.subscriber.show') ? 'menu-open' : ' ' }}">

                    @if (((Auth::user()->type) == 1) ||  ((Auth::user()->type) == 2))
                    <a title="Clients" href="#" class="nav-link">
                        <i class="nav-icon fas fa-user-cog"></i>
                        <p class="ml-2">Clients <i class="right fas fa-angle-left"></i></p>
                    </a>
                    @endif

                    @can('access_to_client_category')
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a title="Client Category" href="{{route('admin.subscriber-category.index')}}" class="nav-link {{ ( $route == 'admin.subscriber-category.index' || $route == 'admin.subscriber-category.create' || $route == 'admin.subscriber-category.edit') ? 'dashboard-link' : ' ' }}">
                                <p class="nav-link-p-nasted">  <i class="fas fa-layer-group nav-iconCategory"></i>Client Category</p>
                            </a>
                        </li>
                    </ul>
                    @endcan

                    @can('access_to_client')
                    @if ((Auth::user()->type) == 1)
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a title="Client" href="{{route('admin.subscriber.index')}}" class="nav-link {{ ( $route == 'admin.subscriber.index' || $route == 'admin.subscriber.edit' || $route == 'admin.subscriber.create' || $route == 'admin.subscriber.show') ? 'dashboard-link' : ' ' }}">
                                <p class="nav-link-p-nasted"><i class="nav-icon fas fa-user-cog"></i> Client </p>
                            </a>
                        </li>
                    </ul>
                    @endif
                    @endcan

                    @if ((Auth::user()->type) == 2)
                     <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a title="View Profile" href="{{route('admin.client-dashboard.show', (Auth::user()->subscriber_id) ) }}" class="nav-link {{ ( $route == 'admin.client-dashboard.show') ? 'dashboard-link' : ' ' }}">
                                <p class="nav-link-p-nasted"><i class="nav-icon fas fa-user"></i>View Profile</p>
                            </a>
                        </li>
                    </ul>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a title="Billing History" href="{{ route('admin.billing-history',(Auth::user()->subscriber_id)) }}" class="nav-link {{ ( $route == 'admin.billing-history') ? 'dashboard-link' : ' ' }}">
                                <p class="nav-link-p-nasted"><i class="nav-icon fas fa-history"></i>Billing History</p>
                            </a>
                        </li>
                    </ul>
                    @endif

                </li>


                @if ((Auth::user()->type) == 2)

                <li class="nav-item {{ ($route == 'admin.subscriber-category.index' || $route == 'admin.subscriber-category.create' || $route == 'admin.subscriber-category.edit' || $route == 'admin.subscriber.index' || $route == 'admin.subscriber.edit' || $route == 'admin.subscriber.create' || $route == 'admin.client-dashboard.index' || $route == 'admin.subscriber.show' || $route == 'admin.client-bill-request') ? 'menu-open' : ' ' }}">

                    <a title="Requests" href="#" class="nav-link">
                        <i class="nav-icon fas fa-user"></i>
                        <p class="ml-2">Requests<i class="right fas fa-angle-left"></i></p>
                    </a>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a title="Bill Pay" href="{{route('admin.client-bill-request')}}" class="nav-link {{ ( $route == 'admin.package.index' || $route == 'admin.package.create' || $route == 'admin.package.edit' || $route == 'admin.client-bill-request') ? 'dashboard-link' : ' ' }}">
                                <p class="nav-link-p-nasted"><i class="fas fa-money-bill-alt nav-icon"></i>Bill Pay</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif

                <li class="nav-item {{ ($route == 'admin.bill.index' || $route == 'admin.bill.create' || $route == 'admin.bill.edit' || $route == 'admin.bill.show' || $route == 'admin.bill-list' || $route == 'admin.paid-client' || $route == 'admin.unpaid-client' || $route =='admin.bill-pay.index' || $route == 'admin.bill-pay.create' || $route == 'admin.bill-pay.edit' || $route == 'admin.monthly-bills') ? 'menu-open' : ' ' }}">

                    @can('access_to_bill')
                    <a title="Billing" href="#" class="nav-link">
                        <i class="nav-icon fas fa-receipt"></i>
                        <p class="ml-2">Billing<i class="right fas fa-angle-left"></i></p>
                    </a>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a title="Billing Process" href="{{route('admin.bill.index')}}" class="nav-link {{ ( $route == 'admin.bill.index') ? 'dashboard-link' : ' ' }}">
                                <p class="nav-link-p-nasted"><i class="fas fa-sync-alt nav-icon"></i>Billing Process</p>
                            </a>
                        </li>
                    </ul>
                     @endcan

                     @can('bill_list')
                     <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a title="Bill List" href="{{route('admin.bill-list')}}" class="nav-link {{ ( $route == 'admin.bill-list' || $route == 'admin.monthly-bills' || $route == 'admin.bill.create' || $route == 'admin.bill.edit' || $route == 'admin.bill.show') ? 'dashboard-link' : ' ' }}">
                                <p class="nav-link-p-nasted"><i class="fas fa fa-list nav-icon"></i>Bill List</p>
                            </a>
                        </li>
                    </ul>
                    @endcan

                     @can('bill_pay')
                     <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a title="Bill Pay" href="{{route('admin.bill-pay.index')}}" class="nav-link  {{ ( $route == 'admin.bill-pay.index' || $route == 'admin.bill-pay.create' || $route == 'admin.bill-pay.edit') ? 'dashboard-link' : ' ' }}">
                                <p class="nav-link-p-nasted"><i class="fas fa-money-bill-alt nav-icon"></i>Bill Pay </p>
                            </a>
                        </li>
                    </ul>
                    @endcan

                     @can('paid_client')
                     <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a title="Paid Cients" href="{{route('admin.paid-client')}}" class="nav-link {{ ( $route == 'admin.paid-client') ? 'dashboard-link' : ' ' }}">
                                <p class="nav-link-p-nasted"><i class="nav-icon fas fa-user-cog"></i>Paid Cients </p>
                            </a>
                        </li>
                    </ul>
                    @endcan

                     @can('unpaid_client')
                     <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a title="Un-Paid Cients" href="{{route('admin.unpaid-client')}}" class="nav-link {{ ( $route == 'admin.unpaid-client') ? 'dashboard-link' : ' ' }}">
                                <p class="nav-link-p-nasted"><i class="nav-icon fas fa-user-cog"></i>Un-Paid Cients </p>
                            </a>
                        </li>
                    </ul>
                    @endcan
                </li>

                <li class="nav-item {{ ($route == 'admin.staff.index' || $route == 'admin.staff.create' || $route == 'admin.staff.edit' || $route == 'admin.staff.show')  ? 'menu-open' : ' ' }}">

                    @if (((Auth::user()->type) == 1) || ((Auth::user()->type) == 3))
                    <a title="Staff" href="#" class="nav-link">
                       <i class="nav-icon fas fa-user"></i>
                       <p class="ml-2">Staff <i class="right fas fa-angle-left"></i></p>
                    </a>
                    @endif

                    @if ((Auth::user()->type) == 3)
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a title="View Profile" href="{{route('admin.staff-profile', (Auth::user()->staff_id) ) }}" class="nav-link {{ ( $route == 'admin.staff-profile') ? 'dashboard-link' : ' ' }}">
                                    <p class="nav-link-p-nasted"><i class="nav-icon fas fa-user"></i>View Profile</p>
                                </a>
                            </li>
                        </ul>
                    @endif

                    @can('access_to_staff')
                    @if ((Auth::user()->type) == 1)
                    <ul class="nav nav-treeview">
                       <li class="nav-item">
                           <a title="Staff List" href="{{route('admin.staff.index')}}" class="nav-link {{ ( $route == 'admin.staff.index' || $route == 'admin.staff.create' || $route == 'admin.staff.edit') ? 'dashboard-link' : ' ' }}">
                               <p class="nav-link-p-nasted"><i class="fas fa-user nav-icon"></i>Staff List</p>
                           </a>
                       </li>
                    </ul>
                    @endif
                    @endcan
               </li>

                <li class="nav-item {{ ($route == 'admin.classification.index' || $route == 'admin.classification.create' || $route == 'admin.classification.edit' || $route == 'admin.complaint.index' || $route == 'admin.complaint.create' || $route == 'admin.complaint.edit' || $route == 'admin.complaint.show')  ? 'menu-open' : ' ' }}">

                    @if ( ((Auth::user()->type) == 1) ||  ((Auth::user()->type) == 2))
                    <a title="Complaint" href="#" class="nav-link">
                        <i class="nav-icon fas fa-file-signature"></i>
                        <p class="ml-2">Complaint<i class="right fas fa-angle-left"></i></p>
                     </a>
                    @endif

                     @can('classification_create')
                     <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a title="Classification" href="{{route('admin.classification.index')}}" class="nav-link {{ ( $route == 'admin.classification.index' || $route == 'admin.classification.create' || $route == 'admin.classification.edit') ? 'dashboard-link' : ' ' }}">
                                <p class="nav-link-p-nasted"><i class="fas fa-map-marker-alt nav-icon"></i> Classification</p>
                            </a>
                        </li>
                     </ul>
                     @endcan

                     @if (((Auth::user()->type) == 1) ||  ((Auth::user()->type) == 2))
                     <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a title="Complaint" href="{{route('admin.complaint.index')}}" class="nav-link {{ ( $route == 'admin.complaint.index' || $route == 'admin.complaint.create' || $route == 'admin.complaint.edit' || $route == 'admin.complaint.show') ? 'dashboard-link' : ' ' }}">
                                <p class="nav-link-p-nasted"><i class="fas fa-street-view nav-icon"></i>Complaint </p>
                            </a>
                        </li>
                    </ul>
                    @endif

                </li>

                <li class="nav-item {{ ($route == 'admin.request-area-list' || $route == 'admin.request-connection-list' || $route == 'admin.request-package-list' || $route == 'admin.request-bill')  ? 'menu-open' : ' ' }}">

                    @if (((Auth::user()->type) == 1) ||  ((Auth::user()->type) == 2))
                    <a title="Client Requests" href="#" class="nav-link">
                        <i class="nav-icon fas fa-envelope"></i>
                        <p class="ml-2">Client Requests<i class="right fas fa-angle-left"></i></p>
                    </a>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a title="Request Area" href="{{ route('admin.request-area-list') }}" class="nav-link {{ ( $route == 'admin.request-area-list') ? 'dashboard-link' : ' ' }}">
                                <p class="nav-link-p-nasted"><i class="fas fa-map-marker-alt nav-icon"></i>Request Area </p>
                            </a>
                        </li>
                    </ul>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a title="Request Package" href="{{ route('admin.request-package-list') }}" class="nav-link {{ ( $route == 'admin.request-package-list') ? 'dashboard-link' : ' ' }}">
                                <p class="nav-link-p-nasted"><i class="fas fa-network-wired nav-icon"></i>Request Package</p>
                            </a>
                        </li>
                    </ul>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a title="Request Bill-Pay" href="{{ route('admin.request-bill') }}" class="nav-link {{ ( $route == 'admin.request-bill' ) ? 'dashboard-link' : ' ' }}">
                                <p class="nav-link-p-nasted"><i class="fas fa-money-bill-alt nav-icon"></i>Request Bill-Pay</p>
                            </a>
                        </li>
                    </ul>
                    @endif

                </li>

                <li class="nav-item {{ ($route == 'admin.transactions.index' || $route == 'admin.transactions.create' || $route == 'admin.transactions.edit' || $route == 'admin.transactions.show' || $route == 'admin.balance' || $route == 'admin.account-statement' || $route == 'admin.fund-transfer.index' || $route == 'admin.fund-transfer.create' || $route == 'admin.fund-transfer.edit')  ? 'menu-open' : ' ' }}">

                    @can('access_to_account')
                    <a title="Account" href="#" class="nav-link">
                        <i class="fas fa-users nav-icon"></i>
                        <p class="ml-2">Account <i class="right fas fa-angle-left"></i></p>
                    </a>
                    @endcan

                    @can('access_to_deposit_withdraw')
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a title="Deposit/Withdraw" href="{{route('admin.transactions.index')}}" class="nav-link {{ ( $route == 'admin.transactions.index' || $route == 'admin.transactions.create' || $route == 'admin.transactions.edit' || $route == 'admin.transactions.show') ? 'dashboard-link' : '' }}">
                                <p class="nav-link-p-nasted"><i class="fas fa-exchange-alt nav-icon"></i>Deposit/Withdraw</p>
                            </a>
                        </li>
                    </ul>
                    @endcan

                    @can('balance_sheet')
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a title="Balance Sheet" href="{{route('admin.balance')}}" class="nav-link {{ ( $route == 'admin.balance' ) ? 'dashboard-link' : '' }}">
                                <p class="nav-link-p-nasted"><i class="fas fa-users nav-icon"></i>Balance Sheet</p>
                            </a>
                        </li>
                    </ul>
                    @endcan

                    @can('account_statement')
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a title="Accounts Statement" href="{{route('admin.account-statement')}}" class="nav-link {{ ( $route == 'admin.account-statement' ) ? 'dashboard-link' : '' }}">
                                <p class="nav-link-p-nasted"><i class="fas fa-users nav-icon"></i>Accounts Statement</p>
                            </a>
                        </li>
                    </ul>
                    @endcan

                    @can('access_to_balance_transfer')
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a title="Fund Transfer" href="{{route('admin.fund-transfer.index')}}" class="nav-link {{ ( $route == 'admin.fund-transfer.index' || $route == 'admin.fund-transfer.create' || $route == 'admin.fund-transfer.edit' ) ? 'dashboard-link' : '' }}">
                                <p class="nav-link-p-nasted"><i class="fas fa-exchange-alt nav-icon"></i>Fund Transfer </p>
                            </a>
                        </li>
                    </ul>
                    @endcan
                </li>

                <li class="nav-item {{ ( $route == 'admin.expense-category.index' || $route == 'admin.expense-category.create' || $route == 'admin.expense-category.edit' || $route == 'admin.expense.index' || $route == 'admin.expense.create' || $route == 'admin.expense.edit' || $route == 'admin.expense.show') ? 'menu-open' : ' ' }}">
                    @can('access_to_expense')
                    <a title="Expense" href="#" class="nav-link">
                        {{-- <i class="fas fa-hand-holding-usd nav-icon"></i> --}}
                        <i class="fas fa-minus-circle nav-icon"></i>
                        <p class="ml-2">Expense<i class="right fas fa-angle-left"></i></p>
                    </a>
                    @endcan

                    @can('access_to_expense_category')
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a title="Expense Category" href="{{route('admin.expense-category.index')}}" class="nav-link  {{ ( $route == 'admin.expense-category.index' || $route == 'admin.expense-category.create' || $route == 'admin.expense-category.edit' ) ? 'dashboard-link' : '' }}">
                                <p class="nav-link-p-nasted"><i class="fas fa-hand-holding-usd nav-icon"></i>Expense Category</p>
                            </a>
                        </li>
                    </ul>
                    @endcan

                     @can('access_to_expense')
                     <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a title="Expenses" href="{{route('admin.expense.index')}}" class="nav-link {{ ( $route == 'admin.expense.index' || $route == 'admin.expense.create' || $route == 'admin.expense.edit' || $route == 'admin.expense.show') ? 'dashboard-link' : '' }}">
                                <p class="nav-link-p-nasted"><i class="fas fa-hand-holding-usd nav-icon"></i>Expenses</p>
                            </a>
                        </li>
                    </ul>
                    @endcan
                </li>

                <li class="nav-item {{ ( $route == 'admin.subscriber-list' || $route == 'admin.report-package' || $route == 'admin.report-connection' || $route == 'admin.report-area' || $route == 'admin.report-category' || $route == 'admin.report-device' || $route == 'admin.billing-client') ? 'menu-open' : ' ' }}">

                    @can('access_to_report')
                    <a title="Report" href="#" class="nav-link">
                        <i class="fas fa-file nav-icon"></i>
                        <p class="ml-2">Report<i class="right fas fa-angle-left"></i></p>
                    </a>
                    @endcan

                    @can('client_report')
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a title="Clients" href="{{route('admin.subscriber-list')}}" class="nav-link {{ ( $route == 'admin.subscriber-list' ) ? 'dashboard-link' : '' }}">
                                <p class="nav-link-p-nasted"><i class="nav-icon fas fa-user-cog nav-icon"></i>Clients </p>
                            </a>
                        </li>
                    </ul>
                    @endcan

                    @can('client_history')
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a title="Client History" href="{{route('admin.billing-client')}}" class="nav-link {{ ( $route == 'admin.billing-client') ? 'dashboard-link' : ' ' }}">
                                <p class="nav-link-p-nasted"><i class="nav-icon fas fa-user-cog"></i>Client History</p>
                            </a>
                        </li>
                    </ul>
                    @endcan

                    @can('area_report')
                     <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a title="Areas" href="{{route('admin.report-area')}}" class="nav-link {{ ( $route == 'admin.report-area' ) ? 'dashboard-link' : '' }}">
                                <p class="nav-link-p-nasted"><i class="nav-icon fas fa-user-cog nav-icon"></i>Areas </p>
                            </a>
                        </li>
                    </ul>
                    @endcan

                     @can('connection_report')
                     <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a title="Connections" href="{{route('admin.report-connection')}}" class="nav-link {{ ( $route == 'admin.report-connection' ) ? 'dashboard-link' : '' }}">
                                <p class="nav-link-p-nasted"><i class="nav-icon fas fa-user-cog nav-icon"></i>Connections </p>
                            </a>
                        </li>
                    </ul>
                    @endcan

                     @can('package_report')
                     <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a title="Packages" href="{{route('admin.report-package')}}" class="nav-link {{ ( $route == 'admin.report-package' ) ? 'dashboard-link' : '' }}">
                                <p class="nav-link-p-nasted"><i class="nav-icon fas fa-user-cog nav-icon"></i>Packages </p>
                            </a>
                        </li>
                    </ul>
                    @endcan

                     @can('device_report')
                     <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a title="Devices" href="{{route('admin.report-device')}}" class="nav-link {{ ( $route == 'admin.report-device' ) ? 'dashboard-link' : '' }}">
                                <p class="nav-link-p-nasted"><i class="nav-icon fas fa-user nav-icon"></i>Devices </p>
                            </a>
                        </li>
                    </ul>
                    @endcan

                     @can('client_category_report')
                     <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a title="Client Categories" href="{{route('admin.report-category')}}" class="nav-link {{ ( $route == 'admin.report-category' ) ? 'dashboard-link' : '' }}">
                                <p class="nav-link-p-nasted"><i class="nav-icon fas fa-user nav-icon"></i>Client Categories</p>
                            </a>
                        </li>
                    </ul>
                    @endcan
                </li>

                @can('access_role_permission')
                <li class="nav-item {{ ( $route == 'admin.role.index' || $route == 'admin.permission.index' || $route == 'admin.role.create' || $route == 'admin.role.edit' || $route == 'admin.permission.create' || $route == 'admin.permission.edit') ? 'menu-open' : ' ' }}">
                    <a title="Administrator" href="#" class="nav-link " >
                       <i class="fa fa-user" aria-hidden="true"></i>
                        <p class="ml-2">Administrator<i class="right fas fa-angle-left"></i></p>
                    </a>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a title="Role" href="{{route('admin.role.index')}}" class="nav-link  {{ ( $route == 'admin.role.index' || $route == 'admin.role.create' || $route == 'admin.role.edit') ? 'dashboard-link' : '' }}">
                                <p class="nav-link-p-nasted"><i class="fa fa-users"></i> Role</p>
                            </a>
                        </li>
                    </ul>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a title="Permission" href="{{route('admin.permission.index')}}" class="nav-link {{ ( $route == 'admin.permission.index' || $route == 'admin.permission.create' || $route == 'admin.permission.edit') ? 'dashboard-link' : '' }}">
                                <p class="nav-link-p-nasted">  <i class="fa fa-users"></i> Permission </p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endcan
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
