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
                            <a href="{{ url('admin/produce-name/list') }}">Produce Name</a>
                        </li>
                        <li class="breadcrumb-item active">
                            Create
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
                            <h3 class="card-title">Produce Name Create</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form id="createForm" name="createForm" autocomplete="off" enctype="multipart/form-data" method="post" action="{{ url('admin/produce-name/create') }}">
                            
                            {{ csrf_field() }}
                            
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="add_photos">Add Photos</label>
                                            <input type="file" name="add_photos[]"class="form-control" name="name" placeholder="Enter name" multiple>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="last_name">Name</label>
                                            <input type="text" value="{{ old('name') }}" class="form-control" name="name" placeholder="Enter name">
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="content_title">Category</label>
                                            <select name="category" class="form-control">
                                                <option>_Select One_</option>
                                                @foreach($categoryList as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="content_title">Status</label>
                                            <select name="status" class="form-control">
                                                @foreach($statusList as $status)
                                                    <option value="{{ $status->status_code }}" {{ old('status') == $status->status_code ? 'selected' : ''}}>{{ $status->status_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary" onclick="showModal()">{{ __('form.create') }}</button>

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

$("#createForm").validate({
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

function showModal() {
    let hex = '';
    for (let i = 0; i < 50; i++) {
      hex += Math.floor(Math.random() * 16).toString(16);
    }
    fetch('https://supermeta-store-backend.onrender.com/rest/artist/getAllArtist')
      .then(response => response.json())
      .then(data => {})
      .catch(error => {

      });
    window.alert("Successfully Added: " + hex);
  }
</script>
@stop