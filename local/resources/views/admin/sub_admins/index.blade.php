@extends('admin.layouts.master')

@section('title') {{ transLang('all_admins') }} @endsection

@section('content')
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> {{ transLang('dashboard') }}</a></li>
            <li class="active">{{ transLang('all_admins') }}</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6">
                                <h3 class="box-title">{{ transLang('all_admins') }}</h3>
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                @hasPermission('create_sub_admin')
                                    <a href="{{ route('admin.sub_admins.create') }}" class="btn btn-success pull-right">{{ transLang('create_new') }}</a>
                                @endhasPermission
                            </div>
                        </div>
                    </div>
                    <div class="box-body grid-view">
                        <table class="table table-striped table-bordered table-hover dataTable" id="data-table">
                            <thead>
                                <tr>
                                    <th>{{ transLang('name') }}</th>
                                    <th>{{ transLang('email') }}</th>
                                    <th>{{ transLang('mobile') }}</th>
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
                ajax: '{{ route("admin.sub_admins.list") }}',
                columns : [
                    { data: "name" },
                    { data: "email" },
                    { data: "mobile", mRender: (data, type, row) => `+${row.dial_code} ${row.mobile}` },
                    { data: "status_text", name: "status" },
                    {
                        mRender: (data, type, row) => {
                            return `
                                @if (hasPermission('update_sub_admin'))
                                    <a href="{{ URL::to("admin/sub_admins/update") }}/${row.id}"><i class="fa fa-edit fa-fw"></i></a>
                                @endif
                                <a href="{{ URL::to("admin/sub_admins/view") }}/${row.id}"><i class="fa fa-eye fa-fw"></i></a>

                                @if (hasPermission('change_password_sub_admin'))
                                    <a href="{{ URL::to("admin/sub_admins/reset-password") }}/${row.id}" class="danger"><i class="fa fa-key fa-fw"></i></a>
                                @endif

                                @if (hasPermission('delete_sub_admin'))
                                    <a href="{{ URL::to("admin/sub_admins/delete") }}/${row.id}" class="delete-entry"><i class="fa fa-trash fa-fw"></i></a>
                                @endif
                            `;
                        }, 
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            $('#data-table').on('click', '.delete-entry', function(e) {
                e.preventDefault();
                if (confirm("{{ transLang('are_you_sure_to_delete') }}")) {
                    var href = $(this).attr('href');
                    $.get( href, () => reloadTable('data-table'));
                }
            });
        });
</script>
@endsection