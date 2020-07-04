@extends('admin.layouts.master') 

@section('title') {{ transLang('app_settings') }} @endsection
 
@section('content')
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> {{ transLang('dashboard') }} </a></li>
            <li class="active">{{ transLang('app_settings') }}</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{ transLang('app_settings') }}</h3>
                    </div>
                    <div class="box-body">
                        <p class="alert message_box hide"></p>
                        <form class="form-horizontal" id="save-frm">
                            @csrf
                            @foreach ($settings as $row)
                                <div class="form-group">
                                    <label class="col-sm-3 control-label required">{{ $row->label }}</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="{{ $row->attribute }}" placeholder="{{ $row->label }}" value="{{ $row->value }}">
                                    </div>
                                </div>
                            @endforeach
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
                dataType: 'json',
                type: 'POST',
                url: "{{ route('admin.settings.update') }}",
                data: $('#save-frm').serialize(),
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
                }
            });
        });
    });

</script>
@endsection