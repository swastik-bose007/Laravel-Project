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
                        <li class="breadcrumb-item active"> User Edit</li>
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
                            <h3 class="card-title">{{ __('common.update_user_details') }}</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form id="updateUserForm" name="updateUserForm" autocomplete="off" enctype="multipart/form-data" method="post" action="{{ url('/admin/user-management/update') }}">
                            
                            {{ csrf_field() }}
                            <input type="hidden" value="{{ $user->slug }}" name="slug">
                            
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="first_name">{{ __('form.first_name') }}</label>
                                            <input type="text" value="{{ $user->first_name }}" class="form-control" name="first_name" placeholder="{{ __('form.enter_first_name') }}">
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="last_name">{{ __('form.last_name') }}</label>
                                            <input type="text" value="{{ $user->last_name }}" class="form-control" name="last_name" placeholder="{{ __('form.enter_last_name') }}">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="email">{{ __('form.email') }}</label>
                                            <input type="text" value="{{ $user->email }}" class="form-control" name="email" disabled="true">
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="email">Phone No.</label>
                                            <input type="text" value="{{ $user->phone }}" class="form-control" name="phone" placeholder="Enter Phone number" disabled="true">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="user_type">{{ __('form.user_type') }}</label>
                                            <select class="form-control" name="user_type">
                                                @foreach($userRoles as $roles)
                                                    <option value="{{ $roles->id }}" {{ $user->getRoles->id == $roles->id ? 'selected' : ''}}>{{ $roles->name }}</option>
                                                @endforeach>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="user_type">Status</label>
                                            <select class="form-control" name="status">
                                                @foreach($statusList as $s)
                                                    <option value="{{ $s->status_code }}" {{ $user->status == $s->status_code ? 'selected' : ''}}>{{ $s->status_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">{{ __('form.update') }}</button>

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
$("#updateUserForm").validate({
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