@extends('admin.layouts.master')

@section('title') {{ transLang('all_subscriptions') }} @endsection

@section('content')
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> {{ transLang('dashboard') }}</a></li>
            <li class="active">{{ transLang('all_subscriptions') }}</li>
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
                                <h3 class="box-title">{{ transLang('all_subscriptions') }}</h3>
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                <a href="{{ route('admin.subscriptions.create') }}" class="btn btn-success pull-right">{{ transLang('create_new') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="box-body grid-view">
                        <table class="table table-striped table-bordered table-hover dataTable" id="data-table">
                            <thead>
                                <tr>
                                    <th>{{ transLang('name') }}</th>
                                    <th>{{ transLang('en_name') }}</th>
                                    <th>{{ transLang('price') }} ({{ config('cms.default_currency') }})</th>
                                    <th>{{ transLang('duration') }}</th>
                                    <th>{{ transLang('status') }}</th>
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
                ajax: '{{ route("admin.subscriptions.list") }}',
                columns : [
                    { "data": "name" },
                    { "data": "en_name" },
                    { "data": "price" },
                    { "data": "duration_text", "name":"duration" },
                    { "data": "status" },
                    {
                        "mRender": function (data, type, row) {
                            let response = `<a href="{{ URL::to("admin/subscriptions/update") }}/${row.id}"><i class="fa fa-edit fa-fw"></i></a>`;
                            if(row.id != 1) {
                                response += `<a href="{{ URL::to("admin/subscriptions/delete") }}/${row.id}" class="delete-entry" ><i class="fa fa-trash fa-fw"></i></a>`;
                            }
                            return response;
                        }, 
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            $('#data-table').on('click', '.delete-entry', function(e){
                e.preventDefault();
                if (confirm("{{ transLang('are_you_sure_to_delete') }}")) {
                    var href = $(this).attr('href');
                    $.get( href, () => reloadTable('data-table'));
                }
            });
        });
    </script>
@endsection