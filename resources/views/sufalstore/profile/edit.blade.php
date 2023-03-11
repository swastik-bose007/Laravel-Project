@extends('sufalstore.layouts.default')

@section('content')


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        @include('sufalstore.includes.alert-message')

        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Profile</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('sufalstore/dashboard') }}">Home</a></li>
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
                                     src="{{ url(Auth::guard('sufalstore')->user()->profile_picture_url) }}"
                                     alt="User profile picture">
                            </div>

                            <h3 class="profile-username text-center">{{ Auth::guard('sufalstore')->user()->first_name . ' ' . Auth::guard('sufalstore')->user()->last_name }}</h3>

                            <p class="text-muted text-center">sufalstore</p>

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Produce</b> <a class="float-right">{{ $produceCount }}</a>
                                </li>
                            </ul>
                            <a type="button" href="{{url('sufalstore/profile/image-update/'.Auth::guard('sufalstore')->user()->id)}}" class="btn btn-primary btn-block"><b>Change Profile Image</b></a>
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
                            <form id="profileUpdateForm" name="profileUpdateForm" autocomplete="off" enctype="multipart/form-data" method="post" action="{{ url('/sufalstore/profile/update') }}">
                                {{ csrf_field() }}
                                
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="content_title">Sufal Store Name</label>
                                            <input type="text" name="sufal_store_name" class="form-control" value="{{ Auth::guard('sufalstore')->user()->first_name . ' ' . Auth::guard('sufalstore')->user()->last_name }}" placeholder="Enter bazar mandi name">
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="content_title">Sufal Store Type</label>
                                            <select name="sufal_store_type" class="form-control">
                                                <option value="{{Auth::guard('sufalstore')->user()->sufal_store_type }}" >{{ucfirst(strtolower(Auth::guard('sufalstore')->user()->sufal_store_type))}}</option>
                                                @if(Auth::guard('sufalstore')->user()->sufal_store_type == 'big')
                                                <option value="small">Small</option>
                                                @else
                                                <option value="big">Big</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                   

                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="content_title">Area</label>
                                            <input type="text" name="area" class="form-control" value="{{Auth::guard('sufalstore')->user()->area }}" placeholder="Enter area">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="content_title">District</label>
                                            <input type="text" name="district" class="form-control" value="{{ Auth::guard('sufalstore')->user()->district }}" placeholder="Enter district">
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="content_title">Pincode</label>
                                            <input type="text" name="pincode" class="form-control" value="{{ Auth::guard('sufalstore')->user()->pincode }}" placeholder="Enter pincode">
                                        </div>
                                    </div>
                                </div>

                                <hr />

                                <h3>Registered Store Attendant</h3>

                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="content_title">First Name</label>
                                            <input type="text" name="registered_store_attendant_first_name" class="form-control" value="{{ Auth::guard('sufalstore')->user()->registered_store_attendant_first_name }}" placeholder="Enter store attendant's first name">
                                        </div>
                                    </div>

                                     <div class="col-6">
                                        <div class="form-group">
                                            <label for="content_title">Last Name</label>
                                            <input type="text" name="registered_store_attendant_last_name" class="form-control" value="{{ Auth::guard('sufalstore')->user()->registered_store_attendant_last_name }}" placeholder="Enter store attendant's last name">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="content_title">Adhar No</label>
                                            <input type="text" name="registered_store_attendant_adhar_no" class="form-control" value="{{ Auth::guard('sufalstore')->user()->registered_store_attendant_adhar_no }}" placeholder="Enter adhar no" disabled>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="content_title">Phone no</label>
                                            <input type="text" name="registered_store_attendant_phone" class="form-control" value="{{ Auth::guard('sufalstore')->user()->registered_store_attendant_phone }}" placeholder="Enter phone no">
                                        </div>
                                    </div>
                                </div>

                                <hr />


                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="content_title">Email</label>
                                            <input type="text" name="email" class="form-control" value="{{ Auth::guard('sufalstore')->user()->email }}" placeholder="Enter email" disabled>
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
                            <form id="changePasswordForm" name="changePasswordForm" autocomplete="off" enctype="multipart/form-data" method="post" action="{{ url('/sufalstore/profile/change-password') }}">
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