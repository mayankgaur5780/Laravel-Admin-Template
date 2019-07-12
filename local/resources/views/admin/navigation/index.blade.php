@extends('admin.layouts.master')

@section('title') {{ transLang('all_navigation') }} @endsection

@section('content')
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> {{ transLang('dashboard') }}</a></li>
            <li class="active">{{ transLang('all_navigation') }}</li>
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
                                <h3 class="box-title">{{ transLang('all_navigation') }}</h3>
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                <a href="{{ route('admin.navigation.create') }}" class="btn btn-success pull-right">{{ transLang('create_new') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="box-body">
                        <table class="table table-striped table-bordered table-hover dataTable" id="navigation-table">
                            <thead>
                                <tr>
                                    <th>{{ transLang('id') }}</th>
                                    <th>{{ transLang('name') }}</th>
                                    <th>{{ transLang('en_name') }}</th>
                                    <th>{{ transLang('action_path') }}</th>
                                    <th>{{ transLang('display_order') }}</th>
                                    <th>{{ transLang('type') }}</th>
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
        $('#navigation-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("admin.navigation.list") }}',
            columns : [
                { "data": "id"},
                { "data": "name"},
	            { "data": "en_name" },
                { "data": "action_path" },
	            { "data": "display_order" },
                { "data": "type" },
                { "data": "status" },
                {
                    "mRender": function (data, type, row) {
                        return `
                            <a href="{{ URL::to("admin/navigation/update") }}/${row.id}"><i class="fa fa-edit fa-fw"></i></a>
                        `;
                    }, 
                    orderable: false
                }
	        ],
            order : [[0, 'desc']]
        });
    });

</script>
@endsection