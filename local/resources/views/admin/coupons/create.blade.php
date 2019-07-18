@extends('admin.layouts.master') 
@section('title') {{ transLang('create_coupon') }} @endsection
 
@section('content')

<section class="content-header">
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> {{ transLang('dashboard') }}</a></li>
        <li><a href="{{ route('admin.coupons.index') }}"> {{ transLang('all_coupons') }} </a></li>
        <li class="active">{{ transLang('create_coupon') }}</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ transLang('create_coupon') }}</h3>
                </div>
                <div class="box-body">
                    <p class="alert message_box hide"></p>
                    <form id="save-frm" class="form-horizontal">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label class="col-sm-2 control-label required">{{ transLang('coupon_code') }}</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="coupon_code" placeholder="{{ transLang('coupon_code') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label required">{{ transLang('type') }}</label>
                            <div class="col-sm-6">
                                <select class="form-control select2-class" name="type" data-placeholder="{{ transLang('choose') }}">
                                    <option value=""></option>
                                    <option value="1">{{ transLang('flat') }}</option>
                                    <option value="2">{{ transLang('percentage') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label required">{{ transLang('discount') }}</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="discount" placeholder="{{ transLang('discount') }}">
                            </div>
                        </div>
                        <div class="form-group percentage-wrapper">
                            <label class="col-sm-2 control-label required">{{ transLang('max_discount') }}</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="max_discount" placeholder="{{ transLang('max_discount') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label required">{{ transLang('valid_from') }}</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control date-picker" name="valid_from" placeholder="{{ transLang('valid_from') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label required">{{ transLang('valid_to') }}</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control date-picker" name="valid_to" placeholder="{{ transLang('valid_to') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label required">{{ transLang('per_user_usage') }}</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="per_user_usage" placeholder="{{ transLang('per_user_usage') }}" value="0">
                                <small class="grey">{{ transLang('per_user_usage_hint') }}</small>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="status" class="col-sm-2 control-label required">{{ transLang('status') }}</label>
                            <div class="col-sm-6">
                                <select class="form-control" name="status">
                                    @foreach(transLang('action_status') as $key => $status)
                                        <option value="{{ $key }}">{{ $status }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="box-footer">
                    <div class="col-sm-offset-1 col-sm-6">
                        <button type="button" class="btn btn-success" id="saveBtn">
                            <i class="fa fa-check"></i> {{ transLang('create') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
 
@section('scripts')
    <script type="text/javascript">
        jQuery(function($) {
            $(document).on('change', '[name="type"]', function (e) {
                $('.percentage-wrapper').hide();
                if($(this).val() == 2) {
                    $('.percentage-wrapper').show();
                }
            });

            $(document).on('click','#saveBtn',function(e) {
                e.preventDefault();
                const btn = $(this);
                const loader = $('.message_box');
                
                $.ajax({
                    dataType: 'json',
                    type: 'POST',
                    url: "{{ route('admin.coupons.create') }}",
                    data: new FormData($('#save-frm')[0]),
                    processData: false,
                    contentType: false,
                    beforeSend: () => {
                        btn.attr('disabled',true);
                        loader.html(`{!! transLang('loader_message') !!}`).removeClass('hide alert-danger alert-success').addClass('alert-info');
                    },
                    error: (jqXHR, exception) => {
                        btn.attr('disabled',false);
                        loader.html(formatErrorMessage(jqXHR, exception)).removeClass('alert-info').addClass('alert-danger');
                    },
                    success: response => {
                        btn.attr('disabled',false);
                        loader.html(response.message).removeClass('alert-info').addClass('alert-success');
                        location.replace('{{ route("admin.coupons.index")}}');
                    }
                });
            });
        });
    </script>
@endsection