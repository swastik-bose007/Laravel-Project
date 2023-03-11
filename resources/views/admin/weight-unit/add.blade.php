@extends('admin.layouts.default')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        @include('admin.includes.alert-message')

        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Unit Management</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/weight-unit/list') }}">Unit Management</a></li>
                        <li class="breadcrumb-item active">Create Unit</li>
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
                            <h3 class="card-title">Create New Unit</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form id="createCategoryForm" name="createCategoryForm" autocomplete="off" enctype="multipart/form-data" method="post" action="{{ url('/admin/weight-unit/add') }}">
                            
                            {{ csrf_field() }}
                            
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text" value="" class="form-control" name="unit_name" placeholder="Enter Unit name">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="name">Symbol</label>
                                            <input type="text" value="" class="form-control" name="unit_symbol" placeholder="Enter Unit symbol">
                                        </div>
                                    </div>
                                     <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="user_type">Status</label>
                                            <select class="form-control" name="status">
                                                <option value="">-Select One-</option>
                                                @foreach($statusList as $s)
                                                    <option value="{{ $s->status_code }}">{{ $s->status_name }}</option>
                                                @endforeach
                                            </select>
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
function wordCalculator() {
    let wordCount = $("#description").val().length;
    $("#viewWordCount").html("Character left: " + parseInt(1000 - wordCount));
}

$("#createCategoryForm").validate({
    rules: {
        unit_name: {
            required: true,
            maxlength: 60
        },
        unit_symbol: {
            required: true,
            maxlength: 60
        },
        status: {
            required: true
        }
    }
});
</script>
@stop