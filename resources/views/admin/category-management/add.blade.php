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
                        <li class="breadcrumb-item active">Create Category</li>
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
                            <h3 class="card-title">Create New User</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form id="createCategoryForm" name="createCategoryForm" autocomplete="off" enctype="multipart/form-data" method="post" action="{{ url('/admin/category-management/create') }}">
                            
                            {{ csrf_field() }}
                            
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="parent_category">Parent Category</label>
                                            <select class="form-control" name="parent_category">
                                                <option value="0" {{ old('parent_category') == 0 ? 'selected' : ''}}>Main</option>
                                                @foreach($categoryList as $cl)
                                                    <option value="{{ $cl->id }}" {{ old('parent_category') == $cl->id ? 'selected' : ''}}>{{ $cl->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text" value="{{ old('name') }}" class="form-control" name="name" placeholder="Category name">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="Description">Description</label>
                                            <textarea onkeyup="wordCalculator()" class="form-control" id="description" name="description" placeholder="Category description" maxlength="1000">{{ old('description') }}</textarea>

                                            <p id="viewWordCount">Character left: 1000</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="last_name">Priority</label>
                                            <input type="text" value="{{ old('priority') }}" class="form-control" name="priority" placeholder="Category priority">
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="user_type">Editable</label>
                                            <select class="form-control" name="is_editable">
                                                <option value="1" {{ old('is_editable') == 1 ? 'selected' : ''}}>Yes</option>
                                                <option value="0" {{ old('is_editable') == 0 ? 'selected' : ''}}>No</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
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