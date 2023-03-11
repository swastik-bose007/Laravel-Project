<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="ltr">
    <head>
        @include('admin.includes.head')
    </head>
    
    <body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
        <div class="wrapper">

            <!-- Preloader -->
            <div class="preloader flex-column justify-content-center align-items-center">
                <img class="animation__wobble" src="{{ url('public/theme/admin/dist/img/kridarplogo.png') }}" alt="kridarplogo" height="60" width="60">
            </div>

            <!-- Navbar -->
            @include('admin.includes.header')
            <!-- /.navbar -->

            <!-- Main Sidebar Container -->
            @include('admin.includes.left-menu')

            <!-- Content Wrapper. Contains page content -->
            @yield('content')
            <!-- /.content-wrapper -->

            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
                <!-- Control sidebar content goes here -->
            </aside>
            <!-- /.control-sidebar -->

            <!-- Main Footer -->
            @include('admin.includes.footer')
        </div>
        <!-- ./wrapper -->

        <!-- REQUIRED SCRIPTS -->
        
        <!-- Bootstrap -->
        <script src="{{ url('public/theme/admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <!-- overlayScrollbars -->
        <script src="{{ url('public/theme/admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
        <!-- AdminLTE App -->
        <script src="{{ url('public/theme/admin/dist/js/adminlte.js') }}"></script>

        <!-- PAGE PLUGINS -->
        <!-- jQuery Mapael -->
        <script src="{{ url('public/theme/admin/plugins/jquery-mousewheel/jquery.mousewheel.js') }}"></script>
        <script src="{{ url('public/theme/admin/plugins/raphael/raphael.min.js') }}"></script>
        <script src="{{ url('public/theme/admin/plugins/jquery-mapael/jquery.mapael.min.js') }}"></script>
        <script src="{{ url('public/theme/admin/plugins/jquery-mapael/maps/usa_states.min.js') }}"></script>
        <!-- ChartJS -->
        <script src="{{ url('public/theme/admin/plugins/chart.js/Chart.min.js') }}"></script>

        <!-- AdminLTE for demo purposes -->
        <script src="{{ url('public/theme/admin/dist/js/demo.js') }}"></script>
        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <script src="{{ url('public/theme/admin/dist/js/pages/dashboard2.js') }}"></script>
        
        <!-- sweet alert -->
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        
        <script>
            function logout() {
                swal("Do you want to logout ?", {
                    buttons: ["No", "Yes"],
                }).then((value) => {
                    if(value) {
                        redirect("{{ url('admin/logout') }}");
                    }
                });
            }

            function redirect(link) {
                window.location.replace(link);
            }

            function deleteData(link) {
                swal("Do you want to delete ?", {
                    buttons: ["No", "Yes"],
                }).then((value) => {
                    if(value) {
                        window.location.replace(link);
                    }
                });
            }

            function deleteProductImage(link) {
                swal("This image will be deleted. Do you want to continue?", {
                    buttons: ["No", "Yes"],
                }).then((value) => {
                    if(value) {
                        window.location.replace(link);
                    }
                });
            }
            function deleteProfileImage(link) {
                swal("This image will be deleted. Do you want to continue?", {
                    buttons: ["No", "Yes"],
                }).then((value) => {
                    if(value) {
                        window.location.replace(link);
                    }
                });
            }

            function bigImage(x)
            {
                x.style.height="300px";
                x.style.width="300px";
                
            }

            function smallImage(x)
            {
                x.style.height="200px";
                x.style.width="200px";
                
            }
            
            function deleteGallaryContent(link) {
                swal("This content will be deleted. Do you want to continue?", {
                    buttons: ["No", "Yes"],
                }).then((value) => {
                    if(value) {
                        window.location.replace(link);
                    }
                });
            }

            function setProfilePicture(link) {
                swal("Do you want to set it as your profile picture?", {
                    buttons: ["No", "Yes"],
                }).then((value) => {
                    if(value) {
                        window.location.replace(link);
                    }
                });
            }

             function setDemoProfilePicture(link) {
                swal("Do you want to set a demo photo as your profile picture?", {
                    buttons: ["No", "Yes"],
                }).then((value) => {
                    if(value) {
                        window.location.replace(link);
                    }
                });
            }

            function statusChange(link) {
                swal("Do you want to change status ?", {
                    buttons: ["No", "Yes"],
                }).then((value) => {
                    if(value) {
                        window.location.replace(link);
                    }
                });
            }
            
            $(document).ready(function () {
                setTimeout(function () {
                    $(".alert").fadeOut(500);
                }, 10000);
            });

            $("#searchForm").validate({
                rules: {
                    search_keyword: {
                        required: true,
                        maxlength: 50
                    }
                },
                messages: {
                }
            });
        </script>
    </body>
</html>

