<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ env('APP_NAME') }} | Admin Login</title>

        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{ url('public/theme/admin/plugins/fontawesome-free/css/all.min.css') }}">
        <!-- icheck bootstrap -->
        <link rel="stylesheet" href="{{ url('public/theme/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{ url('public/theme/admin/dist/css/adminlte.min.css') }}">
        <style>
            label.error {
                color: red;
                font-weight: normal;
            }
        </style>
    </head>
    <body class="hold-transition login-page">
        <div class="login-box">
            <!-- /.login-logo -->
            <div class="card card-outline card-primary">
                <div class="card-header text-center">
                    <a href="{{ url('admin/login') }}" class="h1"><b>{{ env('APP_NAME') }}</b></a>
                </div>
                <div class="card-body">
                    <p class="login-box-msg">Sign in to start your session</p>

                    @include('admin.includes.alert-message')
                    
                    <form id="loginForm" name="loginForm" autocomplete="off" enctype="multipart/form-data" method="post" action="{{ url('/admin/login') }}">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="content_title">Email</label>
                                    <input type="text" name="email" class="form-control" value="{{ old('email') }}" placeholder="Email">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="content_title">Password</label>
                                    <input type="password" name="password" class="form-control" placeholder="Password">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-8">
                                <div class="icheck-primary">
                                    <input type="checkbox" id="remember">
                                    <label for="remember">
                                        Remember Me
                                    </label>
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-4">
                                <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                            </div>
                            <!-- /.col -->
                        </div>
                    </form>

                    <p class="mb-1">
                        <a href="{{ url('admin/forgot-password') }}">I forgot my password</a>
                    </p>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.login-box -->

        <!-- jQuery -->
        <script src="{{ url('public/theme/admin/plugins/jquery/jquery.min.js') }}"></script>
        <!-- Bootstrap 4 -->
        <script src="{{ url('public/theme/admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <!-- AdminLTE App -->
        <script src="{{ url('public/theme/admin/dist/js/adminlte.min.js') }}"></script>
        
        <!-- jquery validations -->
        <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
        <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>

        <!-- sweet alert -->
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

        <script>
            $("#loginForm").validate({
                rules: {
                    email: {
                        required: true,
                        email: true,
                        maxlength: 60
                    },
                    password: {
                        required: true,
                        minlength: 6,
                        maxlength: 20
                    }
                },
                messages: {
                    email: {
                        required: "Email is required.",
                        email: "Email is not valid.",
                        maxlength: "Email is not valid."
                    },
                    password: {
                        required: "Password is required.",
                        minlength: "Password at least 6 characters.",
                        maxlength: "Password not more then 20 characters."
                    }
                }
            });

            $(document).ready(function () {
                setTimeout(function () {
                    $(".alert").fadeOut(500);
                }, 10000);
            });
        </script>
    </body>
</html>

