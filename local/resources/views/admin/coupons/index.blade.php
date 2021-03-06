@extends('admin.layouts.master')

@section('title') {{ transLang('all_coupons') }} @endsection

@section('content')
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> {{ transLang('dashboard') }}</a></li>
            <li class="active">{{ transLang('all_coupons') }}</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6">
                                <h3 class="box-title">{{ transLang('all_coupons') }}</h3>
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                @hasPermission('admin.coupons.create')
                                    <a href="{{ route('admin.coupons.create') }}" class="btn btn-success pull-right">{{ transLang('create_new') }}</a>
                                @endhasPermission
                            </div>
                        </div>
                    </div>
                    <div class="box-body grid-view">
                        <table class="table table-striped table-bordered table-hover dataTable" id="data-table">
                            <thead>
                                <tr>
                                    <th>{{ transLang('coupon_code') }}</th>
                                    <th>{{ transLang('type') }}</th>
                                    <th>{{ transLang('discount') }}</th>
                                    <th>{{ transLang('valid_from') }}</th>
                                    <th>{{ transLang('valid_to') }}</th>
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
                ajax: '{{ route("admin.coupons.list") }}',
                columns : [
                    { data: "coupon_code" },
                    { data: "type", mRender: data => data == 1 ? '{{ transLang('flat') }}' : '{{ transLang('percentage') }}' },
                    { data: "discount" },
                    { data: "valid_from", mRender: data => formatDate(data, 'YYYY-MM-DD') },
                    { data: "valid_to", mRender: data => formatDate(data, 'YYYY-MM-DD') },
                    { data: "status_text", name: "status" },
                    {
                        mRender: (data, type, row) => {
                            return `
                                @if (hasPermission('admin.coupons.update'))
                                    <a href="{{ route("admin.coupons.update") }}/${row.id}"><i class="fa fa-edit fa-fw"></i></a>
                                @endif
                                @if (hasPermission('admin.coupons.delete'))
                                    <a href="{{ route("admin.coupons.delete") }}/${row.id}" class="delete-entry" data-tbl="data"><i class="fa fa-trash fa-fw"></i></a>
                                @endif
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