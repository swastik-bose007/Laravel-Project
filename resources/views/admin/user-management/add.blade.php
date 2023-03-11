@extends('admin.layouts.default')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        @include('admin.includes.alert-message')

        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('common.user_management') }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/user-management/list') }}">{{ __('common.user_management') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('common.create_user') }}</li>
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
                            <h3 class="card-title">{{ __('common.create_new_user') }}</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form id="createUserForm" name="createUserForm" autocomplete="off" enctype="multipart/form-data" method="post" action="{{ url('/admin/user-management/create') }}">
                            
                            {{ csrf_field() }}
                            
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="first_name">{{ __('form.first_name') }}</label>
                                            <input type="text" value="{{ old('first_name') }}" class="form-control" name="first_name" placeholder="{{ __('form.enter_first_name') }}">
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="last_name">{{ __('form.last_name') }}</label>
                                            <input type="text" value="{{ old('last_name') }}" class="form-control" name="last_name" placeholder="{{ __('form.enter_last_name') }}">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="email">{{ __('form.email') }}</label>
                                            <input type="text" value="{{ old('email') }}" class="form-control" name="email" placeholder="{{ __('form.enter_email') }}">
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="email">Phone No.</label>
                                            <input type="text" value="{{ old('phone') }}" class="form-control" name="phone" placeholder="Enter Phone number">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="user_type">{{ __('form.user_type') }}</label>
                                            <select class="form-control" name="user_type">
                                                @foreach($userRoles as $roles)
                                                    <option value="{{ $roles->id }}" {{ old('user_type') == $roles->id ? 'selected' : ''}}>{{ $roles->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="user_type">Status</label>
                                            <select class="form-control" name="status">
                                                @foreach($statusList as $s)
                                                    <option value="{{ $s->status_code }}" {{ old('status') == $s->status_code ? 'selected' : ''}}>{{ $s->status_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="password">{{ __('form.password') }}</label>
                                            <div class="input-group">
                                                <input type="password" id="password" name="password" class="form-control" placeholder="{{ __('form.enter_password') }}">
                                                <span class="input-group-append">
                                                    <button type="button" class="btn btn-info btn-flat" onClick="generatePassword(8);">{{ __('form.generate_password') }}</button>
                                                </span>
                                            </div>

                                            <label id="password-error" class="error" for="password"></label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" onclick="showPassword();">
                                            <label class="form-check-label" for="show_password">Show password.</label>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="confirm_password">{{ __('form.confirm_password') }}</label>
                                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="{{ __('form.enter_password_again') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">{{ __('form.create') }}</button>

                                <button type="button" class="btn btn-primary" onClick="redirect('{{ url()->previous() }}');">{{ __('form.back') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div><!--/. container-fluid -->
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

$("#createUserForm").validate({
    rules: {
        first_name: {
            required: true,
            maxlength: 60
        },
        last_name: {
            required: true,
            maxlength: 60
        },
        email: {
            required: true,
            email: true,
            maxlength: 60
        },
        phone: {
            required: true,
            digits: true
        },
        user_type: {
            required: true
        },
        password: {
            required: true,
            minlength: 6,
            maxlength: 20
        },
        password_confirmation: {
            equalTo : "#password"
        }
    },
    messages: {
        first_name: {
            required: "{{ __('form.first_name_is_required') }}",
            maxlength: "{{ __('form.first_name_is_not_valid') }}"
        },
        last_name: {
            required: "{{ __('form.last_name_is_required') }}",
            maxlength: "{{ __('form.last_name_is_not_valid') }}"
        },
        email: {
            required: "{{ __('form.email_is_required') }}",
            email: "{{ __('form.email_is_not_valid') }}",
            maxlength: "{{ __('form.email_is_not_valid') }}"
        },
        user_type: {
            required: "{{ __('form.user_type_is_required') }}"
        },
        password: {
            required: "{{ __('form.password_is_required') }}",
            minlength: "{{ __('form.password_at_least_6_characters') }}",
            maxlength: "{{ __('form.password_not_more_then_20_characters') }}"
        },
        password_confirmation: {
            equalTo: "{{ __('form.enter_same_password') }}"
        }
    }
});
</script>
@stop