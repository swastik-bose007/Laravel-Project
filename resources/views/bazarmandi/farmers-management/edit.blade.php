@extends('bazarmandi.layouts.default')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        @include('bazarmandi.includes.alert-message')

        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Farmer Management</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ url('bazarmandi/farmers-management/list') }}">Farmer Management</a>
                        </li>
                        <li class="breadcrumb-item active">
                            Edit
                        </li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Farmer Edit</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form id="registerForm" name="registerForm" autocomplete="off" enctype="multipart/form-data"
                            method="post" action="{{ url('/bazarmandi/farmers-management/update') }}">
                            {{ csrf_field() }}

                            <input type="hidden" value="{{ $user->slug }}" name="slug">

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="content_title">First Name</label>
                                            <input type="text" name="first_name" class="form-control"
                                                value="{{ $user->first_name }}" placeholder="Enter first name">
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="content_title">Last Name</label>
                                            <input type="text" name="last_name" class="form-control"
                                                value="{{ $user->last_name }}" placeholder="Enter last name">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="content_title">Adhar No</label>
                                            <input type="text" name="adhar_no" class="form-control"
                                                value="{{ $user->adhar_no }}" placeholder="Enter adhar no" readonly>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="content_title">Pan No</label>
                                            <input type="text" name="pan_no" class="form-control"
                                                value="{{ $user->pan_no }}" placeholder="Enter pan no" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="content_title">Area</label>
                                            <input type="text" name="area" class="form-control"
                                                value="{{ $user->area }}" placeholder="Enter area">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="content_title">District</label>
                                            <input type="text" name="district" class="form-control"
                                                value="{{ $user->district }}" placeholder="Enter district">
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="content_title">Pincode</label>
                                            <input type="text" name="pincode" class="form-control"
                                                value="{{ $user->pincode }}" placeholder="Enter pincode">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="content_title">Email</label>
                                            <input type="text" name="email" class="form-control"
                                                value="{{ $user->email }}" placeholder="Enter email" readonly>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="content_title">Phone no</label>
                                            <input type="text" name="phone_no" class="form-control"
                                                value="{{ $user->phone }}" placeholder="Enter phone no">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">{{ __('form.update') }}</button>

                                <button type="button" class="btn btn-primary"
                                    onClick="redirect('{{ url()->previous() }}');">{{ __('form.back') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!--/. container-fluid -->

            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Chnage Password</h3>
                </div><!-- /.card-header -->
                <div class="card-body">
                    <form id="changePasswordForm" name="changePasswordForm" autocomplete="off"
                        enctype="multipart/form-data" method="post"
                        action="{{ url('/bazarmandi/farmers-management/change-password') }}">
                        {{ csrf_field() }}

                        <input type="hidden" value="{{ $user->slug }}" name="slug">

                        <input type="hidden" value="{{ $user->password }}" name="password_old">

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="content_title">Current Password</label>
                                    <input type="password" name="current_password" id="current_password"
                                        class="form-control" placeholder="Enter current password">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="content_title">Password</label>
                                    <input type="password" name="password" id="password" class="form-control"
                                        placeholder="Enter password">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="content_title">Confirm Password</label>
                                    <input type="password" name="password_confirmation" class="form-control"
                                        placeholder="Confirm password">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-8">

                            </div>
                            <!-- /.col -->
                            <!-- /.col -->
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">{{ __('form.update') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </section>


    <!-- /.content -->
</div>

<script>
function generatePassword(length) {
    var result = '';
    var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var charactersLength = characters.length;
    for (var i = 0; i < length; i++) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
    $("#password").val(result);
    $("#password_confirmation").val(result);
}


function showPassword() {
    var x = document.getElementById("password");
    var y = document.getElementById("password_confirmation");
    if (x.type === "password") {
        x.type = "text";
        y.type = "text";
    } else {
        x.type = "password";
        y.type = "password";
    }
}

$("#createForm").validate({
    rules: {
        produce_name_id: {
            required: true,
            maxlength: 60
        },
        type: {
            required: true,
            maxlength: 60
        },
        quantity: {
            required: true,
            digits: true
        },
    },
    messages: {}
});

<
script >
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
            adhar_no: {
                required: true,
                digits: true,
                maxlength: 12
            },
            pan_no: {
                required: true,
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

$(document).ready(function() {
    setTimeout(function() {
        $(".alert").fadeOut(500);
    }, 10000);
});
</script>
</body>

</html>
@stop