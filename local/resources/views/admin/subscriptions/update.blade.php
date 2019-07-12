@extends('admin.layouts.master') 
@section('title') {{ transLang('update_subscription') }} @endsection
 
@section('content')

<section class="content-header">
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> {{ transLang('dashboard') }}</a></li>
        <li><a href="{{ route('admin.subscriptions.index') }}"> {{ transLang('all_subscriptions') }} </a></li>
        <li class="active">{{ transLang('update_subscription') }}</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ transLang('update_subscription') }}</h3>
                </div>
                <div class="box-body">
                    <p class="alert message_box hide"></p>
                    <form id="save-frm" class="form-horizontal">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label class="col-sm-2 control-label required">{{ transLang('name') }}</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="name" placeholder="{{ transLang('name') }}" value="{{ $subscription->name }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label required">{{ transLang('en_name') }}</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="en_name" placeholder="{{ transLang('en_name') }}" value="{{ $subscription->en_name }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label required">{{ transLang('price') }}</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="price" placeholder="{{ transLang('price') }}" value="{{ $subscription->price }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label required">{{ transLang('duration') }}</label>
                            <div class="col-sm-6">
                                <select class="form-control select2-class" name="duration" data-placeholder="{{ transLang('choose') }}">
                                    <option value=""></option>
                                    @foreach(transLang('subscription_days') as $key => $val)
                                        <option value="{{ $key }}" {{ $subscription->duration == $key ? 'selected' : '' }}>{{ $val }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="status" class="col-sm-2 control-label required">{{ transLang('status') }}</label>
                            <div class="col-sm-6">
                                <select class="form-control" name="status">
                                    @foreach(transLang('action_status') as $key => $status)
                                        <option value="{{ $key }}" {{ $subscription->status == $key ? 'selected' : '' }}>{{ $status }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="box-footer">
                    <div class="col-sm-offset-1 col-sm-6">
                        <button type="button" class="btn btn-success" id="saveBtn">
                            <i class="fa fa-check"></i> {{ transLang('update') }}
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
            $(document).on('click','#saveBtn',function(e) {
                e.preventDefault();
                const btn = $(this);
                const loader = $('.message_box');
                
                $.ajax({
                    dataType: 'json',
                    type: 'POST',
                    url: "{{ route('admin.subscriptions.update', ['id' => $subscription->id]) }}",
                    data: new FormData($('#save-frm')[0]),
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        btn.attr('disabled', true);
                        loader.html('{!! transLang("loader_message") !!}').removeClass('alert-success alert-danger hide').addClass('alert-info');
                    },
                    error: function(jqXHR, exception) {
                        btn.attr('disabled', false);
                        var msg = formatErrorMessage(jqXHR, exception);
                        loader.html(msg).removeClass('alert-info').addClass('alert-danger');
                    },
                    success: function (data) {
                        loader.html(data.message).removeClass('alert-danger').addClass('alert-success');
                        window.location.replace('{{ route("admin.subscriptions.index")}}');
                    }
                });
            });
        });
    </script>
@endsection