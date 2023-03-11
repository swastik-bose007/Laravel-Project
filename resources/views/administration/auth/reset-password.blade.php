<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ env('APP_NAME') }} | Administration Login</title>

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
            <div class="card card-outline card-primary">
                <div class="card-header text-center">
                    <a href="{{ url('/administration/login') }}" class="h1"><b>{{ env('APP_NAME') }}</b></a>
                </div>
                <div class="card-body">
                    <p class="login-box-msg">You are only one step a way from your new password, recover your password now.</p>
                    
                    @include('administration.includes.alert-message')
                    
                    <form id="forgotPasswordForm" name="forgotPasswordForm" autocomplete="off" enctype="multipart/form-data" method="post" action="{{ url('/administration/forgot-password') }}">

                        {{ csrf_field() }}
                        
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" placeholder="Password">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" placeholder="Confirm Password">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-block">Change password</button>
                            </div>
                            <!-- /.col -->
                        </div>
                    </form>

                    <p class="mt-3 mb-1">
                        <p class="mb-1">
                        <a href="{{ url('administration/login') }}">Login</a>
                    </p>
                    </p>
                </div>
                <!-- /.login-card-body -->
            </div>
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
            $("#forgotPasswordForm").validate({
                rules: {
                    email: {
                        required: true,
                        email: true,
                        maxlength: 60
                    }
                },
                highlight: function (element) {
                    $(element).parent().addClass('error')
                },
                unhighlight: function (element) {
                    $(element).parent().removeClass('error')
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
