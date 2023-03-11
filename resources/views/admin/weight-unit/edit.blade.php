@extends('admin.layouts.default')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        @include('admin.includes.alert-message')

        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Category Management</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/category-management/list') }}">Category Management</a></li>
                        <li class="breadcrumb-item active">Edit Category</li>
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
                            <h3 class="card-title">Update Category Details</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form id="updateCategoryForm" name="updateCategoryForm" autocomplete="off" enctype="multipart/form-data" method="post" action="{{ url('/admin/weight-unit/update') }}">
                            
                            {{ csrf_field() }}

                            <input type="hidden" value="{{ $weightUnitList[0]->slug }}" name="slug">
                            
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text" value="{{ $weightUnitList[0]->weight_unit_name }}" class="form-control" name="unit_name" placeholder="Enter Unit name">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="name">Symbol</label>
                                            <input type="text" value="{{ $weightUnitList[0]->symbol }}" class="form-control" name="unit_symbol" placeholder="Enter Unit Symbol">
                                        </div>
                                    </div>
                                </div>
                            </div>

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
$("#updateCategoryForm").validate({
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