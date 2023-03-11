@extends('farmer.layouts.default')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        @include('farmer.includes.alert-message')

        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Update Image</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ url('farmer/profile') }}">
                                Profile
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
                        <form id="updateForm" name="updateForm" autocomplete="off" enctype="multipart/form-data" method="post" action="{{ url('farmer/profile/image-update') }}">
                            
                            {{ csrf_field() }}
                            <input type="hidden" value="{{ $userId }}" name="userId">

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card card-primary">
                                        <div class="card-header">
                                                <h3 class="card-title">Update Image</h3>
                                            </div>
                                            <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="add_photos">Add Photo</label>
                                            <input type="file" name="add_photo"class="form-control">
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Add Image</button>
                            </div>
                        </form>
                        <hr>
                        <hr>
                        <div class="row">
                                <div class="col-sm-12">
                                    <div class="card card-primary">
                                        <div class="card-header">
                                                <h3 class="card-title">Your Uploaded Images  &nbsp</h3><p>( Tap any image to set as profile picture  or set demo profile picture by clicking the button below)</p>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    @foreach($profileImage as $image)
                                                        <div class="image-area">
                                                            <a href="#" onclick="setProfilePicture('{{ url('farmer/profile/set-profile-image/' . $image->id) }}');"><img src="{{url($image->profile_image_url)}}" height="70px" width="70px"  alt="Preview"></a>
                                                            <a class="remove-image" href="#" onclick="deleteProfileImage('{{ url('farmer/profile/delete-profile-image/' . $image->id) }}');" style="display: inline">&#215;</a>
                                                        </div>
                                                        <br>
                                                    @endforeach 
                                                    </div>
                                                    </div>
                                                    <div class="card-footer">
                                <button type="button" class="btn btn-primary" onclick="setDemoProfilePicture('{{ url('farmer/profile/set-demo-profile-image/') }}');">Set Demo Profile Picture Instead</button>
                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                                        
                    </div>
                </section>
            </div>

@stop
