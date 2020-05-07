@extends('admin.layouts.master') 

@section('title') {{ transLang('create_faq') }} @endsection
 
@section('content')
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> {{ transLang('dashboard') }}</a></li>
            <li><a href="{{ route('admin.faq.index') }}"> {{ transLang('all_faq') }} </a></li>
            <li class="active">{{ transLang('create_faq') }}</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{ transLang('create_faq') }}</h3>
                    </div>
                    <div class="box-body">
                        <p class="alert message_box hide"></p>
                        <form id="save-frm" class="form-horizontal">
                            @csrf
                            <div class="form-group">
                                <label class="col-sm-2 control-label required">{{ transLang('title') }}</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="title" placeholder="{{ transLang('title') }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label required">{{ transLang('en_title') }}</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="en_title" placeholder="{{ transLang('en_title') }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label required">{{ transLang('content') }}</label>
                                <div class="col-sm-6">
                                    <textarea type="text" class="form-control" name="content" placeholder="{{ transLang('content') }}"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label required">{{ transLang('en_content') }}</label>
                                <div class="col-sm-6">
                                    <textarea type="text" class="form-control" name="en_content" placeholder="{{ transLang('en_content') }}"></textarea>
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
            $(document).on('click','#saveBtn',function(e) {
                e.preventDefault();
                const btn = $(this);
                const loader = $('.message_box');
                
                $.ajax({
                    dataType: 'json',
                    type: 'POST',
                    url: "{{ route('admin.faq.create') }}",
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
                        location.replace('{{ route("admin.faq.index")}}');
                    }
                });
            });
        });
    </script>
@endsection