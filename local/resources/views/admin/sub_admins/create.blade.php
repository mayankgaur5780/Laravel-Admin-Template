@extends('admin.layouts.master') 

@section('title') {{ transLang('create_admin') }} @endsection
 
@section('content')
	<section class="content-header">
		<ol class="breadcrumb">
			<li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> {{ transLang('dashboard') }}</a></li>
			<li><a href="{{ route('admin.sub_admins.index') }}"> {{ transLang('all_admins') }} </a></li>
			<li class="active">{{ transLang('create_admin') }}</li>
		</ol>
	</section>

	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">{{ transLang('create_admin') }}</h3>
					</div>
					<div class="box-body">
						<p class="alert message_box hide"></p>
						<form class="form-horizontal" id="save-frm">
							@csrf
							<div class="form-group">
								<label class="col-sm-2 control-label required">{{ transLang('role') }}</label>
								<div class="col-sm-6">
									<select class="form-control select2-class" name="role_id" data-placeholder="{{ transLang('choose') }}">
										<option value=""></option>
										@if($roles->count())
											@foreach($roles as $key => $role)
												<option value="{{ $role->id }}">{{ $role->name }}</option>
											@endforeach
										@endif
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label required">{{ transLang('name') }}</label>
								<div class="col-sm-6">
									<input type="text" class="form-control" name="name" placeholder="{{ transLang('name') }}">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label required">{{ transLang('email') }}</label>
								<div class="col-sm-6">
									<input type="email" class="form-control" name="email" placeholder="{{ transLang('email') }}">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label required">{{ transLang('password') }}</label>
								<div class="col-sm-6">
									<input type="password" class="form-control" name="password" placeholder="{{ transLang('password') }}">
								</div>
							</div>
                            <div class="form-group">
                                <label for="mobile" class="col-sm-2 control-label required">{{ transLang('mobile') }}</label>
                                <div class="col-sm-6">
                                    <div class="col-sm-3 no-padding">
                                        <select name="dial_code" class="form-control select2-class" data-placeholder="{{ transLang('choose') }}">
                                            <option value=""></option>
                                            @if ($dial_codes->count())
                                                @foreach ($dial_codes as $item)
                                                    <option value="{{ $item->dial_code }}">{{ $item->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="mobile" placeholder="{{ transLang('mobile') }}">
                                    </div>
                                </div>
                            </div>
							<div class="form-group">
								<label class="col-sm-2 control-label required">{{ transLang('status') }}</label>
								<div class="col-sm-6">
									<select class="form-control" name="status">
										@foreach(transLang('action_status') as $key => $status)
											<option value="{{ $key }}">{{ $status }}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">{{ transLang('profile_image') }}</label>
								<div class="col-sm-6">
									<input type="file" name="profile_image">
								</div>
							</div>
						</form>
					</div>
					<div class="box-footer">
						<div class="col-sm-offset-1 col-sm-6">
							<button type="button" class="btn btn-success" id="createBtn">{{ transLang('create') }}</button>
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
			$(document).on('click','#createBtn',function(e) {
				e.preventDefault();
				let btn = $(this);
				let loader = $('.message_box');

				$.ajax({
					dataType: 'json',
					type: 'POST',
					url: "{{ route('admin.sub_admins.create') }}",
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
						location.replace('{{ route("admin.sub_admins.index")}}');
					}
				});
			});
		});
	</script>
@endsection