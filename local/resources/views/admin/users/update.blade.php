@extends('admin.layouts.master')

@section('title') {{ transLang('update_user') }} @endsection

@section('content')
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> {{ transLang('dashboard') }}</a></li>
            <li><a href="{{ route('admin.users.index') }}">{{ transLang('all_users') }}</a></li>
            <li class="active">{{ transLang('update_user') }}</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{ transLang('update_user') }}</h3>
                    </div>
                    <div class="box-body">
                        <p class="alert message_box hide"></p>
                        <form id="save-frm" class="form-horizontal">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label required">{{ transLang('name') }}</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="name" placeholder="{{ transLang('name') }}" value="{{ $user->name }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="mobile" class="col-sm-2 control-label required">{{ transLang('mobile') }}</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="mobile" value="{{ $user->mobile }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email" class="col-sm-2 control-label">{{ transLang('email') }}</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="email" placeholder="{{ transLang('email') }}" value="{{ $user->email }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email" class="col-sm-2 control-label">{{ transLang('gender') }}</label>
                                <div class="col-sm-6 form-inline">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="gender" value="1" {{ $user->gender == 1 ? 'checked' : '' }}> {{ transLang('male') }}
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="gender" value="2" {{ $user->gender == 2 ? 'checked' : '' }}> {{ transLang('female') }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email" class="col-sm-2 control-label">{{ transLang('dob') }}</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control dob-picker" name="dob" placeholder="{{ transLang('dob') }}" value="{{ $user->dob }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email" class="col-sm-2 control-label">{{ transLang('address') }}</label>
                                <div class="col-sm-6">
                                    <textarea class="form-control" name="address" placeholder="{{ transLang('address') }}">{{ $user->address }}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="status" class="col-sm-2 control-label required">{{ transLang('status') }}</label>
                                <div class="col-sm-6">
                                    <select class="form-control" name="status">
                                        @foreach(transLang('action_status') as $key => $status)
                                            <option value="{{ $key }}" {{ ($user->status == $key) ? 'selected' : ''}}>{{ $status }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="profile_image" class="col-sm-2 control-label">{{ transLang('profile_image') }}</label>
                                <div class="col-sm-6">
                                    @if($user->profile_image)
                                        <img alt="" src="{{ imageBasePath($user->profile_image) }}" width="60" height="60" style="float:left;"/>
                                    @endif
                                    <input type="file" name="profile_image">
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
            $("[name='mobile']").intlTelInput();
            if('{{ $user->dial_code }}' in dial_codes) {
                $("[name='mobile']").intlTelInput("setCountry", dial_codes['{{ $user->dial_code }}']);
            }
            
            $(document).on('click','#updateBtn',function(e){
                e.preventDefault();
                let btn = $(this);
                let loader = $('.message_box');

                if($.trim($('[name="mobile"]').val()) != '' && $('[name="mobile"]').intlTelInput("isValidNumber") == false) {
                    $('.message_box').html('{{ transLang("invalid_mobile_no") }}').removeClass('alert-success hide').addClass('alert-danger');;
                    return false;
                }

                var phone = $('[name="mobile"]').intlTelInput("getSelectedCountryData");
                $('[name="mobile"]').val(($('[name="mobile"]').val()).replace(/ /g, ''));
                var fd = new FormData($('#save-frm')[0]);
                
                fd.append('dial_code', phone.dialCode);

                $.ajax({
                    url: "{{ route('admin.users.update', ['id' => $user->id]) }}",
                    data: fd,
                    processData: false,
                    contentType: false,
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
                        location.replace('{{ route("admin.users.index")}}');
                    }
                });
            });
        });
    </script>

@endsection