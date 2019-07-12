@extends('admin.layouts.master')

@section('title') {{ transLang('all_cms') }} @endsection

@section('content')
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> {{ transLang('dashboard') }}</a></li>
            <li class="active">{{ transLang('all_cms') }}</li>
        </ol>
    </section>

    <section class="content">
        @include('admin.includes.info-box')
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6">
                                <h3 class="box-title">{{ transLang('all_cms') }}</h3>
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                <a href="{{ route('admin.app_cms.create') }}" class="btn btn-success pull-right hide">{{ transLang('create_new') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="box-body grid-view">
                        <table class="table table-striped table-bordered table-hover dataTable" id="data-table">
                            <thead>
                                <tr>
                                    <th>{{ transLang('title') }}</th>
                                    <th>{{ transLang('en_title') }}</th>
                                    <th>{{ transLang('action') }}</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(function() {
            $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route("admin.app_cms.list") }}',
                columns : [
                    { "data": "title" },
                    { "data": "en_title" },
                    {
                        "mRender": function (data, type, row) {
                            return `
                                <a href="{{ URL::to("admin/app_cms/update") }}/${row.id}">
                                    <i class="fa fa-edit fa-fw"></i>
                                </a>
                            `;
                        }, 
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });
    </script>
@endsection