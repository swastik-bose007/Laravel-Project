<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('admin/dashboard') }}" class="brand-link">
        <img src="{{ url('public/theme/admin/dist/img/kridarplogo.png') }}" alt="{{ env('APP_NAME') }} Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">{{ env('APP_NAME') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ url(Auth::guard('admin')->user()->profile_picture_url) }}" class="img-circle elevation-2" alt="User Image">
            </div>

            <div class="info">
                <a href="{{ url('admin/profile') }}" class="d-block">{{ __('common.hello') }}, <strong>{{ Auth::guard('admin')->user()->first_name }}</strong></a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                
                <li class="nav-item">
                    <a href="{{ url('admin/dashboard') }}" class="nav-link {{ Request::is('admin/dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>{{ __('common.dashboard') }}</p>
                    </a>
                </li>
                
                <li class="nav-header">{{ __('common.management') }}</li>
                
                <li class="nav-item">
                    <a href="{{ url('admin/user-management') }}" class="nav-link {{ Request::is('admin/user-management*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user"></i>
                        <p>Users</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('admin/produce-name') }}" class="nav-link {{ Request::is('admin/produce-name*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user"></i>
                        <p>Produce Name</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('admin/category-management') }}" class="nav-link {{ Request::is('admin/category-management*') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-list-alt"></i>
                        <p>Category</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('admin/weight-unit') }}" class="nav-link {{ Request::is('admin/weight-unit*') ? 'active' : '' }}">
                        <i class="fa fa-wrench" aria-hidden="true"></i>
                        <p>&nbsp &nbsp Set Weight Units</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('admin/media') }}" class="nav-link {{ Request::is('admin/media*') ? 'active' : '' }}">
                        <i class="fa-regular fa-image"></i>
                        <p>&nbsp &nbsp Media Library</p>
                    </a>
                </li>

                <li class="nav-header">Others</li>
                
                <li class="nav-item">
                    <a href="{{ url('admin/setting') }}" class="nav-link {{ Request::is('admin/setting') ? 'active' : '' }}">
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