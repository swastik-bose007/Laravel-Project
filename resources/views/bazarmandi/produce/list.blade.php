@extends('bazarmandi.layouts.default')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        @include('bazarmandi.includes.alert-message')

        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Produce</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ url('bazarmandi/produce') }}">Produce</a>
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
                            <h3 class="card-title">Produce List</h3>

                            <div class="card-tools">
                                <form name="searchForm" id="searchForm" method="get" action="{{ url('bazarmandi/produce') }}">
                                <div class="input-group input-group-sm" style="width: 200px;">
                                    <input type="text" name="search_keyword" id="search_keyword" class="form-control float-right" placeholder="{{ __('common.search') }}" value="{{ $searchKeyword }}">

                                    <div class="input-group-append">
                                        <button type="submit" name="search" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>


                                        <a href="{{ url('bazarmandi/produce') }}">
                                            <button type="button" name="refresh" class="btn btn-default">
                                            <i class="fas fa-users"></i>
                                        </button></a>

                                        <button class="btn btn-primary" type="button" onClick="redirect('{{ url('bazarmandi/produce/create') }}');">
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
                                        <th class="text-center">Type</th>
                                        <th class="text-center">Variant</th>
                                        <th class="text-center">Variant Details</th>
                                        <th class="text-center">Quantity</th>
                                        <th class="text-center">Category Name</th>
                                        <th class="text-center">Created At</th>
                                        <th class="text-center">{{ __('common.status') }}</th>
                                        <th class="text-center">{{ __('common.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($listData as $key => $data)
                                    <tr>
                                        <td class="text-center">{{ $key + 1 }}.</td>
                                        <td class="text-center">{{ $data->getProduceName->name }}</td>
                                        <td class="text-center">{{ $data->type }}</td>
                                        @if($data->produce_variant_id==0)
                                        <td class="text-center">Variant Not Available</td>
                                        <td class="text-center">Variant Details Not Available</td>
                                        @else
                                        <td class="text-center">{{ $data->getVariant[0]->name }}</td>
                                        <td class="text-center">{{$data->getVariant[0]->quantity}} {{$data->getVariant[0]->getWeightUnit->weight_unit_name}}</td>
                                        @endif
                                        <td class="text-center">{{ $data->quantity }}</td>
                                        <td class="text-center">{{ $data->getProduceName->getCategory->name }}</td>
                                        <td class="text-center">{{ date('d M, Y h:m A', strtotime($data->created_at)) }}</td>
                                        <td class="text-center">{{ $data->getStatus->status_name }}</td>
                                        <td class="text-center">
                                            <a title="Edit Data" href="{{ url('bazarmandi/produce/edit/' . $data->slug) }}" class="btn-sm btn-primary mr-1">
                                                <i class="fa fa-edit"></i>
                                            </a>

                                            <a title="Delete data" href="#" class="btn-sm btn-primary mr-1" onClick="deleteData('{{ url('bazarmandi/produce/delete/' . $data->slug) }}');">
                                                <i class="fa fa-trash"></i>
                                            </a>


                                            @if($data->status == 1)
                                            <a title="Change Status to Inactive" href="#" class="btn-sm btn-primary mr-1" onClick="statusChange('{{ url('bazarmandi/produce/change-status/' . $data->slug) }}');">
                                                <i class="fa fa-toggle-on"></i>
                                            </a>
                                            @else
                                            <a title="Change Status to Active" href="#" class="btn-sm btn-primary mr-1" onClick="statusChange('{{ url('bazarmandi/produce/change-status/' . $data->slug) }}');">
                                                <i class="fa fa-toggle-off"></i>
                                            </a>
                                            @endif
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