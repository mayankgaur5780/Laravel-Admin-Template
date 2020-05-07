@extends('admin.layouts.master') 

@section('title') {{ transLang('all_settings') }} @endsection
 
@section('content')
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> {{ transLang('dashboard') }} </a></li>
            <li class="active">{{ transLang('all_settings') }}</li>
        </ol>
    </section>

    <section class="content">
        @include('admin.includes.info-box')
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{ transLang('all_settings') }}</h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-striped table-bordered table-hover dataTable" id="settings-table">
                            <thead>
                                <tr>
                                    <th>{{ transLang('attribute') }}</th>
                                    <th>{{ transLang('value') }}</th>
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
        $('#settings-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("admin.settings.list") }}',
            columns : [
	            { data: "label" },
                { data: "value" },
                {
                    mRender: (data, type, row) => {
                        return `<a href="{{ URL::to("admin/settings/update") }}/${row.id}" class="danger"><i class="fa fa-edit fa-fw"></i></a>`;
                    },
                    searchable: false,
                    orderable: false
                }
	        ]
        });
    });

</script>
@endsection