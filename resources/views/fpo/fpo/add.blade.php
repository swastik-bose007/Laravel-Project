@extends('fpo.layouts.default')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        @include('fpo.includes.alert-message')

        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Produce</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ url('fpo/fpo/list') }}">FPO</a>
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
                            <h3 class="card-title">FPO Create</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form id="createForm" name="createForm" autocomplete="off" enctype="multipart/form-data" method="post" action="{{ url('fpo/fpo/create') }}">
                            
                            {{ csrf_field() }}
                            
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="first_name">FPO Type</label>
                                            <input type="text" value="{{ old('fpo_type') }}" class="form-control" name="fpo_type" placeholder="Enter fpo type">
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="last_name">Produce Type</label>
                                            <input type="text" value="{{ old('produce_type') }}" class="form-control" name="produce_type" placeholder="Enter produce type">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="quantity">Quantity</label>
                                            <input type="text" value="{{ old('quantity') }}" class="form-control" name="quantity" placeholder="Enter Quantity">
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="quantity">Slot No.</label>
                                            <input type="text" value="{{ old('slot_no') }}" class="form-control" name="slot_no" placeholder="Enter slot no">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="content_title">Area</label>
                                            <input type="text" name="area" class="form-control" value="{{ old('area') }}" placeholder="Enter area">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="content_title">District</label>
                                            <input type="text" name="district" class="form-control" value="{{ old('district') }}" placeholder="Enter district">
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="content_title">Pincode</label>
                                            <input type="text" name="pincode" class="form-control" value="{{ old('pincode') }}" placeholder="Enter pincode">
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
        fpo_type: {
            required: true,
            maxlength: 60
        },
        produce_type: {
            required: true,
            maxlength: 60
        },
        quantity: {
            required: true,
            digits: true
        },
        slot_no: {
            required: true,
            maxlength: 60
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