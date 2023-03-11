@extends('administration.layouts.default')

@section('content')


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        @include('administration.includes.alert-message')

        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Profile</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('administration/dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Profile</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">

                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle"
                                     src="{{ url(Auth::guard('administration')->user()->profile_picture_url) }}"
                                     alt="User profile picture">
                            </div>

                            <h3 class="profile-username text-center">{{ Auth::guard('administration')->user()->first_name . ' ' . Auth::guard('administration')->user()->last_name }}</h3>

                            <p class="text-muted text-center">administration</p>
                            <a type="button" href="{{url('administration/profile/image-update/'.Auth::guard('administration')->user()->id)}}" class="btn btn-primary btn-block"><b>Change Profile Image</b></a>
                            <a href="javascript:void(0);" onclick="comingSoon()" class="btn btn-primary btn-block"><b>Delete Account</b></a>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
                <div class="col-md-9">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Profile Update</h3>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <form id="profileUpdateForm" name="profileUpdateForm" autocomplete="off" enctype="multipart/form-data" method="post" action="{{ url('/administration/profile/update') }}">
                                {{ csrf_field() }}
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="content_title">First Name</label>
                                            <input type="text" name="first_name" class="form-control" value="{{ Auth::guard('administration')->user()->first_name }}" placeholder="Enter first name">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="content_title">Last Name</label>
                                            <input type="text" name="last_name" class="form-control" value="{{ Auth::guard('administration')->user()->last_name }}" placeholder="Enter last name">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="content_title">Adhar No</label>
                                            <input type="text" name="adhar_no" class="form-control" value="{{ Auth::guard('administration')->user()->adhar_no }}" placeholder="Enter adhar no" disabled>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="content_title">Pan No</label>
                                            <input type="text" name="pan_no" class="form-control" value="{{ Auth::guard('administration')->user()->pan_no }}" placeholder="Enter pan no" disabled>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="content_title">Email</label>
                                            <input type="text" name="email" class="form-control" value="{{ Auth::guard('administration')->user()->email }}" placeholder="Enter email" disabled>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="content_title">Phone no</label>
                                            <input type="text" name="phone_no" class="form-control" value="{{ Auth::guard('administration')->user()->phone }}" placeholder="Enter phone no">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-8">
                                        
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-4">
                                        <button type="submit" class="btn btn-primary btn-block">Update</button>
                                    </div>
                                    <!-- /.col -->
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Chnage Password</h3>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <form id="changePasswordForm" name="changePasswordForm" autocomplete="off" enctype="multipart/form-data" method="post" action="{{ url('/administration/profile/change-password') }}">
                                {{ csrf_field() }}
                                
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="content_title">Current Password</label>
                                            <input type="password" name="current_password" id="current_password" class="form-control" placeholder="Enter current password">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="content_title">Password</label>
                                            <input type="password" name="password" id="password" class="form-control" placeholder="Enter password">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="content_title">Confirm Password</label>
                                            <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm password">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-8">
                                        
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-4">
                                        <button type="submit" class="btn btn-primary btn-block">Change</button>
                                    </div>
                                    <!-- /.col -->
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
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

    $("#profileUpdateForm").validate({
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
            }
        },
        messages: {
            email: {
                required: "Email is required.",
                email: "Email is not valid.",
                maxlength: "Email is not valid."
            }
        }
    });

    $("#changePasswordForm").validate({
        rules: {
            current_password: {
                required: true,
                minlength: 6,
                maxlength: 20
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

    function comingSoon() {
        swal('feature coming soon.');
    }
</script>
@stop