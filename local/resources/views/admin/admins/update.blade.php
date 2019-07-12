@extends('admin.layouts.master') 

@section('title') {{ transLang('update_admin') }} @endsection
 
@section('content')
	<section class="content-header">
		<ol class="breadcrumb">
			<li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> {{ transLang('dashboard') }}</a></li>
			<li><a href="{{ route('admin.admins.index') }}"> {{ transLang('all_admins') }} </a></li>
			<li class="active">{{ transLang('update_admin') }}</li>
		</ol>
	</section>

	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">{{ transLang('update_admin') }}</h3>
					</div>
					<div class="box-body">
						<p class="alert message_box hide"></p>
						<form class="form-horizontal" id="save-frm">
							{{ csrf_field() }}
							<div class="form-group">
								<label class="col-sm-2 control-label">{{ transLang('name') }} <i class="has-error">*</i></label>
								<div class="col-sm-6">
									<input type="text" class="form-control" name="name" placeholder="{{ transLang('name') }}" value="{{ $admin->name }}">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">{{ transLang('email') }} <i class="has-error">*</i></label>
								<div class="col-sm-6">
									<input type="email" class="form-control" name="email" placeholder="{{ transLang('email') }}" value="{{ $admin->email }}">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">{{ transLang('mobile') }} <i class="has-error">*</i></label>

								<div class="col-sm-6">
									<input type="text" class="form-control" name="mobile" placeholder="{{ transLang('mobile') }}" value="{{ $admin->mobile }}">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">{{ transLang('user_type') }} <i class="has-error">*</i></label>
								<div class="col-sm-6">
									<select class="form-control select2-class" name="user_type" data-placeholder="{{ transLang('choose') }}">
										<option value=""></option>
										@if($roles->count())
											@foreach($roles as $key => $role)
												<option value="{{ $role->id }}" {{ ($admin->role_id == $role->id) ? 'selected' : ''}}>{{ $role->name }}</option>
											@endforeach
										@endif
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">{{ transLang('status') }} <i class="has-error">*</i></label>
								<div class="col-sm-6">
									<select class="form-control" name="status">
										@foreach(transLang('action_status') as $key => $status)
											<option value="{{ $key }}" {{ ($admin->status == $key) ? 'selected="selected"' : ''}}>{{ $status }}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">{{ transLang('profile_image') }}</label>
								<div class="col-sm-6">
									@if($admin->profile_image)
										<img src="{{ imageBasePath($admin->profile_image) }}" width="60" style="float:left;" /> 
									@endif
									<input type="file" name="profile_image">
								</div>
							</div>
						</form>
					</div>
					<div class="box-footer">
						<div class="col-sm-offset-1 col-sm-6">
							<button type="button" class="btn btn-success" id="updateBtn">{{ transLang('update') }}</button>
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
				let btn = $(this);
				let loader = $('.message_box');

				$.ajax({
					dataType: 'json',
					type: 'POST',
					url: "{{ route('admin.admins.update', ['id' => $admin->id]) }}",
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
						location.replace('{{ route("admin.admins.index")}}');
					}
				});
			});
		});
	</script>
@endsection