@extends('admin.layouts.master')

@section('title') {{ transLang('all_countries') }} @endsection

@section('content')
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> {{ transLang('dashboard') }}</a></li>
            <li class="active">{{ transLang('all_countries') }}</li>
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
                                <h3 class="box-title">{{ transLang('all_countries') }}</h3>
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                {{-- <a href="{{ route('admin.countries.create') }}" class="btn btn-success pull-right">{{ transLang('create_new') }}</a> --}}
                            </div>
                        </div>
                    </div>
                    <div class="box-body grid-view">
                        <table class="table table-striped table-bordered table-hover dataTable" id="data-table">
                            <thead>
                                <tr>
                                    <th>{{ transLang('flag') }}</th>
                                    <th>{{ transLang('name') }}</th>
                                    <th>{{ transLang('en_name') }}</th>
                                    <th>{{ transLang('dial_code') }}</th>
                                    <th>{{ transLang('alpha_2') }}</th>
                                    <th>{{ transLang('alpha_3') }}</th>
                                    <th>{{ transLang('currency') }}</th>
                                    <th>{{ transLang('tax') . ' (%)' }}</th>
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
            const imagePath = '{{ imageBasePath('', 'flagPath') }}';
            
            $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route("admin.countries.list") }}',
                columns : [
                    { 
                        "data": "flag",
                        "mRender": function (data, type, row) {
                            return data ? `<img src="${imagePath}/${data}" width="40px"/>` : ``;
                        } 
                    },
                    { "data": "country_name" },
                    { "data": "en_country_name" },
                    { "data": "dial_code" },
                    { "data": "alpha_2" },
                    { "data": "alpha_3" },
                    { "data": "currency" },
                    { "data": "tax" },
                    { "data": "status" },
                    {
                        "mRender": function (data, type, row) {
                            return `
                                <a href="{{ URL::to("admin/countries/update") }}/${row.id}">
                                    <i class="fa fa-edit fa-fw"></i>
                                </a>
                                <a href="{{ URL::to("admin/countries/delete") }}/${row.id}" class="delete-entry hide" >
                                    <i class="fa fa-trash fa-fw"></i>
                                </a>
                            `;
                        }, 
                        orderable: false,
                        searchable: false
                    }
                ],
                order : [[8, 'desc']]
            });

            $('#data-table').on('click', '.delete-entry', function(e){
                e.preventDefault();
                if (confirm("{{ transLang('are_you_sure_to_delete') }}")) {
                    var href = $(this).attr('href');
                    $.get( href, function( data ) {
                        $('#data-table').DataTable().ajax.reload();
                    });
                }
            });
        });
    </script>
@endsection