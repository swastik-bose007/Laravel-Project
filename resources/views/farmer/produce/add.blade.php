@extends('farmer.layouts.default')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        @include('farmer.includes.alert-message')

        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Produce</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ url('farmer/produce/list') }}">Produce</a>
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
                            <h3 class="card-title">Produce Create</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form id="createForm" name="createForm" autocomplete="off" enctype="multipart/form-data" method="post" action="{{ url('farmer/produce/create') }}">
                            
                            {{ csrf_field() }}
                            
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="content_title">Produce Name</label>
                                            <div class="spinner-border spinner-border-sm" id="spinner"></div>

                                            <select name="produce_name_id" id="produce_name_id" class="form-control">
                                                <option value="">- Select One -</option>

                                                @foreach($produceNameList as $produceName)
                                                    <option value="{{ $produceName->id }}" {{ old('produce_name_id') == $produceName->id ? 'selected' : ''}} data-slug="{{ $produceName->slug }}" data-category="{{ $produceName->getCategory->name }}">{{ $produceName->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-4" id="produce_variant_view">
                                        <div class="form-group">
                                            <label for="content_title">Produce Variant</label>
                                            <select name="produce_variant_id" id="produce_variant_id" class="form-control">
                                                <option value="">- Select Produce Name First -</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-4" id="category_view">
                                        <div class="form-group">
                                            <label for="category">Category</label>
                                            <input type="text" value="" class="form-control" name="category" id="category" readonly />
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
                                                    <label for="last_name">Type</label>
                                                    <input type="text" value="{{ old('type') }}" class="form-control" name="type" placeholder="Enter type">
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
        produce_name_id: {
            required: true,
            maxlength: 60
        },
        produce_variant_id: {
            required: true,
            maxlength: 60
        },
        type: {
            required: true,
            maxlength: 60
        },
        quantity: {
            required: true,
            digits: true
        },
    },
    messages: {}
});

$(document).ready(function() {
    $("#produce_variant_view").hide();
    $("#category_view").hide();
    $("#spinner").hide();

    $("#produce_name_id").change(function() {
        $("#spinner").show();
        // set category name
        let categoryName = $(this).find(':selected').data('category');

        if(typeof categoryName == "undefined") {
            $("#category_view").hide();
            $("#produce_variant_view").hide();
            $("#spinner").hide();


        } else {
            $("#category_view").show();
            $("#category").val(categoryName);

            // get variant data
            let slug = $(this).find(':selected').data('slug');
            $.ajax({
                type:'GET',
                url:'<?php echo url("farmer/produce/get-produce-name-variant"); ?>/' + slug,
                data:'',
                success:function(data) {
                    $("#spinner").hide();
                    if(data.data.get_variant.length > 0) {
                        let variantHtml = "<option value=''>- Select One -</option>";
                        for(let loop = 0; loop < data.data.get_variant.length; loop++) {
                            variantHtml += '<option value="'+data.data.get_variant[loop].id+'">' + data.data.get_variant[loop].name + '</option>';
                        }
                        $("#produce_variant_view").show();
                        $("#produce_variant_id").html(variantHtml);
                    } else {
                        $("#produce_variant_view").hide();
                        swal('Variant not found.');
                        let variantHtml = "<option value=''>- No Variant -</option>";
                        $("#produce_variant_id").html(variantHtml);
                    }
                }
            });
        }
    });
});
</script>
@stop