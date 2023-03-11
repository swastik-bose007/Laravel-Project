@extends('admin.layouts.default')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        @include('admin.includes.alert-message')

        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Add Variants</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ url('admin/produce-name/variant/list') }}">Variant List</a>
                        </li>
                        <li class="breadcrumb-item active">
                            Create variant of {{$produceNameList[0]->name}}
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
                            <h3 class="card-title">Variant Details</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form id="createForm" name="createForm" autocomplete="off" enctype="multipart/form-data" method="post" action="{{ url('admin/produce-name/variant/create') }}">
                            
                            {{ csrf_field() }}
                            <input type="hidden" value="{{ $produceNameList[0]->id }}" name="produce_name_id">
                            <input type="hidden" value="{{ $produceNameList[0]->slug }}" name="slug">
                            
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="variant_name">Name</label>
                                            <input type="text" value="" class="form-control" name="variant_name" placeholder="Enter name">
                                        </div>
                                    </div>
                                       <div class="col-sm-6">
                                           <div class="form-group">
                                                <label for="quantity">Quantity</label>
                                                <input type="text" value="{{ old('quantity') }}" class="form-control" name="quantity" placeholder="Enter Quantity">
                                          </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="content_title">Set Unit</label>
                                            <select name="weight_unit" id="weight_unit" class="form-control">
                                                <option value="">- Select Unit -</option>
                                                @foreach($weightList as $weight)
                                                    <option value="{{$weight->id}}">{{ $weight->weight_unit_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="content_title">Status</label>
                                            <select name="status" class="form-control">
                                                <option value="">- Select One -</option>
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
</script>
@stop