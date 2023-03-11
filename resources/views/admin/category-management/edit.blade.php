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
                        <form id="updateCategoryForm" name="updateCategoryForm" autocomplete="off" enctype="multipart/form-data" method="post" action="{{ url('/admin/category-management/update') }}">
                            
                            {{ csrf_field() }}

                            <input type="hidden" value="{{ $category->slug }}" name="slug">
                            
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="user_type">Parent Category</label>
                                            <select class="form-control" name="parent_category">
                                                <option value="0" {{ $category->parent_id == 0 ? 'selected' : ''}}>Main</option>
                                                @foreach($categoryList as $cl)
                                                    <option value="{{ $cl->id }}" {{ $category->parent_id == $cl->id ? 'selected' : ''}}>{{ $cl->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text" value="{{ $category->name }}" class="form-control" name="name" placeholder="Category name">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="email">Description</label>
                                            <textarea class="form-control" name="description" placeholder="Category description">
                                                {{ $category->description }}
                                            </textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="last_name">Priority</label>
                                            <input type="text" value="{{ $category->priority }}" class="form-control" name="priority" placeholder="Category priority">
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="user_type">Editable</label>
                                            <select class="form-control" name="is_editable">
                                                <option value="1" {{ $category->is_editable == 1 ? 'selected' : '' }}>Yes</option>
                                                <option value="0" {{ $category->is_editable == 0 ? 'selected' : '' }}>No</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="user_type">Status</label>
                                            <select class="form-control" name="status">
                                                @foreach($statusList as $s)
                                                    <option value="{{ $s->status_code }}" {{ $category->status == $s->status_code ? 'selected' : ''}}>{{ $s->status_name }}</option>
                                                @endforeach
                                            </select>
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
        parent_category: {
            required: true
        },
        name: {
            required: true,
            maxlength: 60
        },
        description: {
            required: true,
            maxlength: 1000
        },
        priority: {
            required: true
        },
        is_editable: {
            required: true
        },
        status: {
            required: true
        }
    }
});
</script>
@stop