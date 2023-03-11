@extends('admin.layouts.default')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        @include('admin.includes.alert-message')

        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Gallary</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ url('admin/dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">Gallary</li>
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
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Media Library</h3>

                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <input type="text" name="table_search" class="form-control float-right" placeholder="{{ __('common.search') }}">

                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>

                                        <button class="btn btn-primary" type="button" onClick="redirect('{{ url('admin/media/create/'.$userId[0]->id) }}');">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0" style="height: 600px;">

                            <div class="card-body">
                                                <div class="row">
                                                    @foreach($mediaList as $media)
                                                        @if($media->type ==='gif'||$media->type ==='jpg'||$media->type ==='jpeg'||$media->type ==='png')
                                                            <div class="image-area">
                                                                <img src="{{url($media->media_url)}}" onmouseover="bigImage(this)" onmouseout="smallImage(this)" height="200px" width="200px" style='border:2px solid skyblue;' alt="image">&nbsp&nbsp&nbsp&nbsp
                                                                <a title="Delete" class="remove-image" href="#" onclick="deleteGallaryContent('{{ url('admin/media/delete/' . $media->id) }}');" style="display: inline">&#215;</a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                                                            </div>
                                                            <br>
                                                            @else
                                                            <div class="video-area">
                                                                <video height="180px" width="315px" style='border:2px solid skyblue;' alt="video" controls>
                                                                    <source src="{{url($media->media_url)}}" type="video/mp4">
                                                                </video>&nbsp&nbsp&nbsp&nbsp
                                                                <a title="Delete" class="remove-image" href="#" onclick="deleteGallaryContent('{{ url('admin/media/delete/' . $media->id) }}');" style="display: inline">&#215;</a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                                                            </div>
                                                            @endif
                                                    @endforeach 

                                                    </div>
                                                    </div>
                            <table class="table table-head-fixed text-nowrap">
                                <tbody>
                                    @if(count($mediaList) === 0)
                                    <tr>
                                        <td colspan="5">No record found.</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="pagination-wrapper">
                        {{ $mediaList->links() }}
                    </div>


                </div>
            </div>
        </div>
    </section>
</div>

@stop