@extends('admin.layouts.default')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        @include('admin.includes.alert-message')

        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Produce Name</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ url('admin/produce-name/list') }}">
                                Produce Name
                            </a>
                        </li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form id="updateForm" name="updateForm" autocomplete="off" enctype="multipart/form-data" method="post" action="{{ url('admin/produce-name/update') }}">
                            
                            {{ csrf_field() }}

                            <input type="hidden" value="{{ $produceName->slug }}" name="slug">
                            <input type="hidden" value="{{ $produceName->id }}" name="parent_id">
                            
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card card-primary">
                                        <div class="card-header">
                                                <h3 class="card-title">Update Image</h3>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    @foreach($imageList as $key => $image)
                                                        <div class="image-area">
                                                            <img src="{{url($produceName->getImage[$key]->produce_image_url)}}" height="70px" width="70px"  alt="Preview">
                                                                <a class="remove-image" href="#" onclick="deleteProductImage('{{url('admin/produce-name/deleteimage/'.$image->id)}}');" style="display: inline">&#215;</a>
                                                        </div>
                                                    @endforeach
                                                    <input type="file" name="add_photos[]" multiple/>       
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                            <div class="col-sm-12">
                                <div class="card card-primary">
                                    <div class="card-header">
                                    <h3 class="card-title">Update Produce Name</h3>
                                    </div>
                                <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="last_name">Name</label>
                                            <input type="text" value="{{ $produceName->name }}" class="form-control" name="name" placeholder="Enter name">
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="content_title">Status</label>
                                            <select name="status" class="form-control">
                                                @foreach($statusList as $status)
                                                    <option value="{{ $status->status_code }}" {{ $produceName->status == $status->status_code ? 'selected' : ''}}>{{ $status->status_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="content_title">Category</label>
                                            <select name="category" class="form-control">
                                                @foreach($categoryList as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
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
$("#updateForm").validate({
    rules: {
        name: {
            required: true,
            maxlength: 60
        },
        status: {
            required: true
        }
    },
    messages: {}
});
</script>
@stop