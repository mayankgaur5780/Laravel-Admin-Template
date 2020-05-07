@extends('admin.layouts.master') 

@section('title') {{ transLang('edit_setting') }} @endsection
 
@section('content')
    <section class="content-header">
        <h1> {{ transLang('edit_setting') }}</h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> {{ transLang('dashboard') }} </a></li>
            <li><a href="{{ route('admin.settings.index') }}"> {{ transLang('all_settings') }} </a></li>
            <li class="active">{{ transLang('edit_setting') }}</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <p class="alert message_box hide"></p>
                        <form id="save-frm" class="form-horizontal">
                            @csrf
                            <div class="form-group">
                                <label for="label" class="col-sm-2 control-label">{{ transLang('attribute') }}</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="label" placeholder="{{ transLang('attribute') }}" value="{{ $setting->label }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="value" class="col-sm-2 control-label">{{ transLang('value') }}</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="value" placeholder="{{ transLang('value') }}" value="{{ $setting->value }}">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="box-footer">
                        <div class="col-sm-offset-1 col-sm-6">
                            <button type="button" class="btn btn-success" id="updateBtn"><i class="fa fa-check"></i> {{ transLang('update') }}</button>
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
      $(document).on('click','#updateBtn',function(e) {
            e.preventDefault();
            const btn = $(this);
            const loader = $('.message_box');
            
            $.ajax({
                url: "{{ route('admin.settings.update', ['id' => $setting->id]) }}",
                data: $('#save-frm').serialize(),
                dataType: 'json',
                type: 'POST',
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
                    location.replace('{{ route("admin.settings.index")}}');
                }
            });
        });
    });

</script>
@endsection