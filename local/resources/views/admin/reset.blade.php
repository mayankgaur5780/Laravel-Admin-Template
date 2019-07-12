@extends('admin.layouts.login-master')

@section('title') {{ transLang('reset_password') }} @endsection

@section('content')
<div class="main-container">
    <div class="main-content">
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                <div class="login-container">
                    <div class="center">
                        <h1>
                            <span class="red">{{ transLang('company') }}.com</span>
                        </h1>
                        <h4 id="id-company-text" class="blue">&copy; {{ transLang('admin_password_reset') }}</h4>
                    </div>
                    <div class="space-6"></div>

                    @if (count($errors) > 0)
                        <div class="alert alert-block alert-danger">
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    @if(Session::has('fail'))
                        <div class="alert alert-block alert-danger">
                            {{ Session::get('fail') }}
                        </div>
                     @endif

                    @if(Session::has('success'))
                        <div class="alert alert-block alert-success">
                            <button type="button" class="close" data-dismiss="alert">
                                <i class="ace-icon fa fa-times"></i>
                            </button>
                            <i class="ace-icon fa fa-check green"></i>
                            {{ Session::get('success') }}
                        </div>
                     @endif

                    <div class="space-6"></div>
                    <div class="position-relative">
                        <div class="forgot-box visible widget-box no-border">
                            <div class="widget-body">
                                <div class="widget-main">
                                    <h4 class="header red lighter bigger">
                                        <i class="ace-icon fa fa-key"></i>
                                        {{ transLang('new_password') }}
                                    </h4>
                                    <div class="space-6"></div>
                                    <form id="reset-form" method="post" action="{{ route('admin.password.reset') }}">
                                        <fieldset>
                                            <label class="block clearfix">
                                                <span class="block input-icon input-icon-right">
                                                    <input type="text" class="form-control" placeholder="Email ID" name="email" value="{{ $email or old('email') }}"/>
                                                    <i class="ace-icon fa fa-envelope"></i>
                                                </span>
                                            </label>

                                            <label class="block clearfix">
                                                <span class="block input-icon input-icon-right">
                                                    <input type="password" class="form-control" placeholder="{{ transLang('new_password') }}" name="password" value="{{ Request::old('password') }}" />
                                                    <i class="ace-icon fa fa-key"></i>
                                                </span>
                                            </label>

                                            <label class="block clearfix">
                                                <span class="block input-icon input-icon-right">
                                                    <input type="password" class="form-control" placeholder="{{ transLang('confirm_password') }}" name="password_confirmation" value="{{ Request::old('password_confirmation') }}" />
                                                    <i class="ace-icon fa fa-key"></i>
                                                </span>
                                            </label>

                                            <div class="clearfix">
                                                <button type="submit" id="reset-submit" class="width-50 pull-right btn btn-sm btn-danger">
                                                    <i class="ace-icon fa fa-key"></i>
                                                    <span class="bigger-110">{{ transLang('reset_password') }}</span>
                                                </button>
                                            </div>
                                        </fieldset>
                                        <input type="hidden" name="_token" value="{{ Session::token() }}">
                                        <input type="hidden" name="token" value="{{ $token }}">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

<script type="text/javascript">
    jQuery(function($) {
        $(document).on('click','#reset-submit',function(e){
            $('#reset-submit').html('Authenticating...').attr('disabled',true).removeClass('width-35').addClass('width-40');
        });
    });
</script>

@endsection