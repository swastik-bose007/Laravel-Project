@extends('developer.layouts.default')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        @include('developer.includes.alert-message')

        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('messages.error_logs') }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('developer/error-logs') }}">Error Logs</a></li>
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
                            <h3 class="card-title">List of errors</h3>

                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0" style="height: 600px;">
                            <table class="table table-head-fixed text-nowrap">
                                <thead>
                                    <tr>
                                        <th class="text-center">ID</th>
                                        <th class="text-center">Code</th>
                                        <th>File</th>
                                        <th class="text-center">Line</th>
                                        <th>Reason</th>
                                        <th class="text-center">Count</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($listData as $key => $data)
                                    <tr>
                                        <td class="text-center">{{ $key + 1 }}</td>
                                        <td class="text-center">{{ $data->code }}</td>
                                        <td>{{ '...' . substr($data->file, strlen($data->file) - 50, strlen($data->file)) }}</td>
                                        <td class="text-center">{{ $data->line }}</td>
                                        <td>{{ '...' . substr($data->message, strlen($data->message) - 50, strlen($data->message)) }}</td>
                                        <td class="text-center">{{ $data->count }}</td>
                                        <td class="text-center">
                                            <a title="view" href="{{ url('developer/error-logs/view/' . $data->id) }}" class="btn-sm btn-primary mr-1">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            
                                            <a title="fixed" href="{{ url('developer/error-logs/fixed/' . $data->id) }}" class="btn-sm btn-primary">
                                                <i class="fas fa-tasks"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
</div>
@stop