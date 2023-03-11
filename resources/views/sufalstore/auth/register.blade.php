<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ env('APP_NAME') }} | Sufal Store Register</title>

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
        <div class="container justify-content-center">
            <!-- /.login-logo -->
            <div class="row">
                <div class="col-12">
                    <div class="card card-outline card-primary mx-auto mt-4 mb-4" style="max-width: 600px;">
                        <div class="card-header text-center">
                            <a href="{{ url('sufalstore/login') }}" class="h1"><b>{{ env('APP_NAME') }}</b></a>
                        </div>
                        <div class="card-body">
                            <p class="login-box-msg">Sufal Store Register</p>

                            @include('sufalstore.includes.alert-message')
                            
                            <form id="registerForm" name="registerForm" autocomplete="off" enctype="multipart/form-data" method="post" action="{{ url('/sufalstore/register') }}">
                                {{ csrf_field() }}
                                
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="content_title">Sufal Store Name</label>
                                            <input type="text" name="sufal_store_name" class="form-control" value="{{ old('sufal_store_name') }}" placeholder="Enter sufal store name">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="content_title">Sufal Store Type</label>
                                            <select name="sufal_store_type" class="form-control">
                                                <option value="big" {{ old('sufal_store_type') == 'big' ? 'selected' : ''}}>Big</option>
                                                <option value="small" {{ old('sufal_store_type') == 'small' ? 'selected' : ''}}>Small</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                </div>


                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="content_title">Area</label>
                                            <input type="text" name="area" class="form-control" value="{{ old('area') }}" placeholder="Enter area">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="content_title">District</label>
                                            <input type="text" name="district" class="form-control" value="{{ old('district') }}" placeholder="Enter district">
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="content_title">Pincode</label>
                                            <input type="text" name="pincode" class="form-control" value="{{ old('pincode') }}" placeholder="Enter pincode">
                                        </div>
                                    </div>
                                </div>

                                <hr />

                                <h3><strong>Registered Store Attendant</strong></h3>

                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="content_title">First Name</label>
                                            <input type="text" name="registered_store_attendant_first_name" class="form-control" value="{{ old('registered_store_attendant_first_name') }}" placeholder="Enter store attendant's first name">
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="content_title">Last Name</label>
                                            <input type="text" name="registered_store_attendant_last_name" class="form-control" value="{{ old('registered_store_attendant_last_name') }}" placeholder="Enter store attendant's last name">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="content_title">Adhar No</label>
                                            <input type="text" name="registered_store_attendant_adhar_no" class="form-control" value="{{ old('registered_store_attendant_adhar_no') }}" placeholder="Enter adhar no">
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="content_title">Phone no</label>
                                            <input type="text" name="registered_store_attendant_phone" class="form-control" value="{{ old('registered_store_attendant_phone') }}" placeholder="Enter phone no">
                                        </div>
                                    </div>
                                </div>

                                <hr />


                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="content_title">Email</label>
                                            <input type="text" name="email" class="form-control" value="{{ old('email') }}" placeholder="Enter email">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="content_title">Password</label>
                                            <input type="password" name="password" id="password" class="form-control" placeholder="Enter password">
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="content_title">Confirm Password</label>
                                            <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm password">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-8">
                                        <a href="{{ url('sufalstore/login') }}">Login</a>
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-4">
                                        <button type="submit" class="btn btn-primary btn-block">Register</button>
                                    </div>
                                    <!-- /.col -->
                                </div>
                            </form>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </div>

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
            $("#registerForm").validate({
                rules: {
                    first_name: {
                        required: true,
                        maxlength: 20
                    },
                    last_name: {
                        required: true,
                        maxlength: 20
                    },
                    sufal_store_type: {
                        required: true,
                    },
                    registered_store_attendant_name: {
                        required: true,
                        maxlength: 40
                    },
                    registered_store_attendant_adhar_no: {
                        required: true,
                        digits: true,
                        maxlength: 12
                    },
                    registered_store_attendant_phone_no: {
                        required: true,
                        digits: true,
                        minlength: 10,
                        maxlength: 10
                    },
                    area: {
                        required: true,
                        maxlength: 20
                    },
                    district: {
                        required: true,
                        maxlength: 20
                    },
                    pincode: {
                        required: true,
                        digits: true,
                        minlength: 6,
                        maxlength: 6
                    },
                    email: {
                        required: true,
                        email: true,
                        maxlength: 60
                    },
                    phone_no: {
                        required: true,
                        digits: true,
                        minlength: 10,
                        maxlength: 10
                    },
                    password: {
                        required: true,
                        minlength: 6,
                        maxlength: 20
                    },
                    password_confirmation: {
                        required: true,
                        equalTo: "#password"
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

