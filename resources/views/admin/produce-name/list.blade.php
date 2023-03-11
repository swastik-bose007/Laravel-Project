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
                            <a href="{{ url('admin/produce-name') }}">Produce Name</a>
                        </li>
                        <li class="breadcrumb-item active">List</li>
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
                            <h3 class="card-title">Produce Name List</h3>

                            <div class="card-tools">
                                <form name="searchForm" id="searchForm" method="get" action="{{ url('admin/produce-name') }}">
                                <div class="input-group input-group-sm" style="width: 200px;">
                                    <input type="text" name="search_keyword" id="search_keyword" class="form-control float-right" placeholder="{{ __('common.search') }}" value="{{ $searchKeyword }}">

                                    <div class="input-group-append">
                                        <button type="submit" name="search" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>


                                        <a href="{{ url('admin/produce-name') }}">
                                            <button type="button" name="refresh" class="btn btn-default">
                                            <i class="fas fa-users"></i>
                                        </button></a>

                                        <button class="btn btn-primary" type="button" onClick="redirect('{{ url('admin/produce-name/create') }}');">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0" style="height: 600px;">
                            <table class="table table-head-fixed text-nowrap">
                                <thead>
                                    <tr>
                                        <th class="text-center">{{ __('common.no') }}</th>
                                        <th class="text-center">{{ __('common.name') }}</th>
                                        <th class="text-center">Produce Image</th>
                                        <th class="text-center">No. of Produce</th>
                                        <th class="text-center">Category</th>
                                        <th class="text-center">Created At</th>
                                        <th class="text-center">{{ __('common.status') }}</th>
                                        <th class="text-center">{{ __('common.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($listData as $key => $data)
                                    <tr>
                                        <td class="text-center">{{ $key + 1 }}.</td>
                                        <td class="text-center">{{ $data->name }}</td>
                                        <td class="text-center"><img src="{{url($data->getImage[0]->produce_image_url)}}" height="50px" width="50px" /></td>

                                        <td class="text-center">{{ count($data->getProduce) }}</td>
                                        <td class="text-center">{{ $data->getCategory->name }}</td>
                                        <td class="text-center">{{ date('d M, Y h:m A', strtotime($data->created_at)) }}</td>
                                        <td class="text-center">{{ $data->getStatus->status_name }}</td>
                                        <td class="text-center">
                                            <a title="Edit Data" href="{{ url('admin/produce-name/edit/' . $data->slug) }}" class="btn-sm btn-primary mr-1">
                                                <i class="fa fa-edit"></i>
                                            </a>

                                            <a title="Delete data" href="#" class="btn-sm btn-primary mr-1" onClick="deleteData('{{ url('admin/produce-name/delete/' . $data->slug) }}');">
                                                <i class="fa fa-trash"></i>
                                            </a>


                                            @if($data->status == 1)
                                            <a title="Change Status to Inactive" href="#" class="btn-sm btn-primary mr-1" onClick="statusChange('{{ url('admin/produce-name/change-status/' . $data->slug) }}');">
                                                <i class="fa fa-toggle-on"></i>
                                            </a>
                                            @else
                                            <a title="Change Status to Active" href="#" class="btn-sm btn-primary mr-1" onClick="statusChange('{{ url('admin/produce-name/change-status/' . $data->slug) }}');">
                                                <i class="fa fa-toggle-off"></i>
                                            </a>
                                            @endif
                                        
                                            <a title="Manage Variants" href="{{ url('admin/produce-name/variant/' . $data->slug) }}" class="btn-sm btn-primary mr-1" >
                                                <i class="fa fa-gavel" aria-hidden="true"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach

                                    @if(count($listData) == 0)
                                    <tr>
                                        <td colspan="5">No record found.</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="pagination-wrapper">
                        {{ $listData->links() }}
                    </div>


                </div>
            </div>
        </div>
    </section>
</div>

@stop