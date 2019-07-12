@extends('admin.layouts.master')

@section('title') {{ transLang('all_role') }} @endsection

@section('content')
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> {{ transLang('dashboard') }}</a></li>
            <li class="active">{{ transLang('all_role') }}</li>
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
                                <h3 class="box-title">{{ transLang('all_role') }}</h3>
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                <a href="{{ route('admin.role.create') }}" class="btn btn-success pull-right">{{ transLang('create_new') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="box-body">
                        <table class="table table-striped table-bordered table-hover dataTable" id="role-table">
                            <thead>
                                <tr>
                                    <th>{{ transLang('id') }}</th>
                                    <th>{{ transLang('name') }}</th>
                                    <th>{{ transLang('status') }}</th>
                                    <th>{{ transLang('action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
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
        $('#role-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("admin.role.list") }}',
            columns : [
                { "data": "id"},
                { "data": "name"},
                { "data": "status" },
                {
                    "mRender": function (data, type, row) {
                        return `
                            <a href="{{ URL::to("admin/role/update") }}/${row.id}"><i class="fa fa-edit fa-fw"></i></a>
                            <a href="{{ URL::to("admin/role/permission") }}/${row.id}"><i class="fa fa-universal-access fa-fw"></i></a>
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