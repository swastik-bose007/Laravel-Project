<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('administration/dashboard') }}" class="brand-link">
        <img src="{{ url('public/theme/admin/dist/img/kridarplogo.png') }}" alt="{{ env('APP_NAME') }} Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">{{ env('APP_NAME') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ url(Auth::guard('administration')->user()->profile_picture_url) }}" class="img-circle elevation-2" alt="User Image">
            </div>

            <div class="info">
                <a href="{{ url('administration/profile') }}" class="d-block">{{ __('common.hello') }}, <strong>{{ Auth::guard('administration')->user()->first_name }}</strong></a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                
                <li class="nav-item">
                    <a href="{{ url('administration/dashboard') }}" class="nav-link {{ Request::is('administration/dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>{{ __('common.dashboard') }}</p>
                    </a>
                </li>
                
                <li class="nav-header">{{ __('common.management') }}</li>
                

                <li class="nav-item {{ Request::is('administration/inventory*') ? 'nav-item menu-is-opening menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Request::is('administration/inventory*') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-sitemap"></i>
                        <p>
                            Inventory
                            <i class="fas fa-angle-left right"></i>
                            <!-- <span class="badge badge-info right">6</span> -->
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('administration/inventory/incoming-purchase') }}" class="nav-link {{ Request::is('administration/inventory/incoming-purchase*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Incoming Purchase</p>
                            </a>
                      </li>
                      <li class="nav-item">
                            <a href="{{ url('administration/inventory/outgoing-orders') }}" class="nav-link {{ Request::is('administration/inventory/outgoing-orders*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Outgoing Orders</p>
                            </a>
                        </li>
                    </ul>
                </li>




                <li class="nav-item">
                    <a href="{{ url('administration/purchase') }}" class="nav-link {{ Request::is('administration/purchase*') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-shopping-cart"></i>
                        <p>Purchase</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('administration/sales') }}" class="nav-link {{ Request::is('administration/sales*') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-tag"></i>
                        <p>Sales</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('administration/revenue') }}" class="nav-link {{ Request::is('administration/revenue*') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Revenue</p>
                    </a>
                </li>

                <li class="nav-header">Others</li>
                
                <li class="nav-item">
                    <a href="{{ url('administration/setting') }}" class="nav-link {{ Request::is('administration/setting') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>{{ __('common.setting') }}</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>