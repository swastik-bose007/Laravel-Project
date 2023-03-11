<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('farmer/dashboard') }}" class="brand-link">
        <img src="{{ url('public/theme/admin/dist/img/kridarplogo.png') }}" alt="{{ env('APP_NAME') }} Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">{{ env('APP_NAME') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <a href="{{ url('farmer/profile') }}">
                <div class="image">
                    <img src="{{ url(Auth::guard('farmer')->user()->profile_picture_url) }}" class="img-circle elevation-2" alt="User Image">
                </div>
            </a>

            <a href="{{ url('farmer/profile') }}">
                <div class="info">
                    <a href="{{ url('farmer/profile') }}" class="d-block">{{ __('common.hello') }}, <strong>{{ Auth::guard('farmer')->user()->first_name }}</strong></a>
                </div>
            </a>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                
                <li class="nav-item">
                    <a href="{{ url('farmer/dashboard') }}" class="nav-link {{ Request::is('farmer/dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>{{ __('common.dashboard') }}</p>
                    </a>
                </li>
                
                <li class="nav-header">Management</li>
                
                <li class="nav-item">
                    <a href="{{ url('farmer/produce') }}" class="nav-link {{ Request::is('farmer/produce*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user"></i>
                        <p>Produce</p>
                    </a>
                </li>

                <li class="nav-header">Others</li>
                
                <li class="nav-item">
                    <a href="{{ url('farmer/setting') }}" class="nav-link {{ Request::is('farmer/setting') ? 'active' : '' }}">
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