@extends('administration.layouts.default')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        @include('administration.includes.alert-message')

        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Incoming Purchase</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ url('administration/inventory/incoming-purchase') }}">Incoming Purchase</a>
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
                            <h3 class="card-title">Incoming Purchase</h3>

                            <div class="card-tools">
                                <form name="searchForm" id="searchForm" method="get" action="{{ url('administration/inventory/incoming-purchase') }}">
                                <div class="input-group input-group-sm" style="width: 200px;">
                                    <input type="text" name="search_keyword" id="search_keyword" class="form-control float-right" placeholder="{{ __('common.search') }}" value="{{ $searchKeyword }}">

                                    <div class="input-group-append">
                                        <button type="submit" name="search" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>


                                        <a href="{{ url('administration/inventory/incoming-purchase') }}">
                                            <button type="button" name="refresh" class="btn btn-default">
                                            <i class="fas fa-users"></i>
                                        </button></a>
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
                                        <th class="text-center">Creator Name</th>
                                        <th class="text-center">Creator Area</th>
                                        <th class="text-center">Purchase Date</th>
                                        <th class="text-center">{{ __('common.name') }}</th>
                                        <th class="text-center">Type</th>
                                        <th class="text-center">Quantity</th>
                                        <th class="text-center">Stock Left</th>
                                        <th class="text-center">{{ __('common.status') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($listData as $key => $data)
                                    <tr>
                                        <td class="text-center">{{ $key + 1 }}.</td>
                                        @if($data->getCreator->created_by == 0)
                                        <td class="text-center">{{ $data->getCreator->first_name . ' ' . $data->getCreator->last_name }}</td>
                                        @else
                                        <td class="text-center">
                                            <div>{{ $data->getCreator->first_name . ' ' . $data->getCreator->last_name }}</div>
                                            <div>(Assigned by {{$data->getCreator->getCreator->first_name.' '.$data->getCreator->getCreator->last_name}})</div>
                                        </td>
                                        @endif
                                        <td class="text-center">{{ $data->getCreator->area }}</td>
                                        <td class="text-center">{{ date('d M, Y h:m A', strtotime($data->created_at)) }}</td>
                                        <td class="text-center">{{ $data->getProduceName->name }}</td>
                                        <td class="text-center">{{ $data->type }}</td>
                                        <td class="text-center">{{ $data->quantity }}</td>
                                        <td class="text-center">{{ $data->stock_left . ' ' . $data->unit }}</td>
                                        <td class="text-center">{{ $data->getStatus->status_name }}</td>
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