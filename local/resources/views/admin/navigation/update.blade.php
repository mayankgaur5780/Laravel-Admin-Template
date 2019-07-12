@extends('admin.layouts.master') 
@section('title') {{ transLang('update_navigation') }}
@endsection
 
@section('content')
	<section class="content-header">
		<ol class="breadcrumb">
			<li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> {{ transLang('dashboard') }}</a></li>
			<li><a href="{{ route('admin.navigation.index') }}"> {{ transLang('all_navigation') }} </a></li>
			<li class="active">{{ transLang('update_navigation') }}</li>
		</ol>
	</section>

	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">{{ transLang('update_navigation') }}</h3>
					</div>
					<div class="box-body">
						<p class="alert message_box hide"></p>
						<form class="form-horizontal" id="update-form" enctype="multipart/form-data">
							<div class="form-group">
								<label for="name" class="col-sm-2 control-label">{{ transLang('name') }} <i class="has-error">*</i></label>
								<div class="col-sm-6">
									<input type="text" class="form-control" name="name" placeholder="{{ transLang('name') }}" value="{{ $navigation->name }}">
								</div>
							</div>

							<div class="form-group">
								<label for="en_name" class="col-sm-2 control-label">{{ transLang('en_name') }} <i class="has-error">*</i></label>
								<div class="col-sm-6">
									<input type="text" class="form-control" name="en_name" placeholder="{{ transLang('en_name') }}" value="{{ $navigation->en_name }}">
								</div>
							</div>

							<div class="form-group">
								<label for="action_path" class="col-sm-2 control-label">{{ transLang('action_path') }} <i class="has-error">*</i></label>
								<div class="col-sm-6">
									<input type="text" class="form-control" name="action_path" placeholder="{{ transLang('action_path') }}" value="{{ $navigation->action_path }}">
								</div>
							</div>

							<div class="form-group">
								<label for="icon" class="col-sm-2 control-label">{{ transLang('icon') }}</label>
								<div class="col-sm-6">
									<input type="text" class="form-control" name="icon" placeholder="{{ transLang('icon') }}" value="{{ $navigation->icon }}">
								</div>
							</div>

							<div class="form-group">
								<label for="display_order" class="col-sm-2 control-label">{{ transLang('display_order') }} <i class="has-error">*</i></label>
								<div class="col-sm-6">
									<input type="text" class="form-control" name="display_order" placeholder="{{ transLang('display_order') }}" value="{{ $navigation->display_order }}">
								</div>
							</div>

							<div class="form-group">
								<label for="parent_id" class="col-sm-2 control-label">{{ transLang('parent_id') }} <i class="has-error">*</i></label>

								<div class="col-sm-6">
									<select class="form-control select2-class" name="parent_id">
										<option value="0">No Parent</option>
										@if($parent_navigation->count())
											@foreach($parent_navigation as $key => $navigation)
												<option value="{{ $navigation->id }}"  {{ ($navigation->parent_id == $nav->id) ? 'selected' : '' }} >{{ $navigation->name }}</option>
											@endforeach
										@endif
								</select>
								</div>
							</div>

							<div class="form-group">
								<label for="parent_id" class="col-sm-2 control-label">{{ transLang('type') }} <i class="has-error">*</i></label>
								<div class="col-sm-6">
									<select class="form-control select2-class" name="type" data-placeholder="{{ transLang('choose') }}">
										<option value=""></option>
										@foreach(transLang('navigation_types') as $key => $val)
											<option value="{{ $key }}" {{ $key == $navigation->type ? 'selected' : '' }}>{{ $val }}</option>
										@endforeach
									</select>
								</div>
							</div>

							<div class="form-group">
								<label for="show_in_menu" class="col-sm-2 control-label">{{ transLang('show_in_menu') }} <i class="has-error">*</i></label>
								<div class="col-sm-6">
									<select class="form-control" name="show_in_menu">
										@foreach(transLang('other_action') as $key => $status)
											<option value="{{ $key }}" {{ ($navigation->show_in_menu == $key) ? 'selected="selected"' : ''}}>{{ $status }}</option>
										@endforeach
									</select>
								</div>
							</div>

							<div class="form-group">
								<label for="show_in_permission" class="col-sm-2 control-label">{{ transLang('show_in_permission') }} <i class="has-error">*</i></label>
								<div class="col-sm-6">
									<select class="form-control" name="show_in_permission">
										@foreach(transLang('other_action') as $key => $status)
											<option value="{{ $key }}" {{ ($navigation->show_in_permission == $key) ? 'selected="selected"' : ''}}>{{ $status }}</option>
										@endforeach
									</select>
								</div>
							</div>
							
							<div class="form-group">
								<label for="status" class="col-sm-2 control-label">{{ transLang('status') }} <i class="has-error">*</i></label>

								<div class="col-sm-6">
									<select class="form-control" name="status">
										@foreach(transLang('action_status') as $key => $status)
											<option value="{{ $key }}" {{ ($navigation->status == $key) ? 'selected="selected"' : ''}}>{{ $status }}</option>
										@endforeach
									</select>
								</div>
							</div>
							<input type="hidden" name="_token" value="{{ Session::token() }}">
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
		$(document).on('click','#updateBtn',function(e){
            e.preventDefault();
			let btn = $(this);
			let loader = $('.message_box');

			$.ajax({
				dataType: 'json',
				type: 'POST',
				url: "{{ route('admin.navigation.update', ['id' => Request::segment(4)]) }}",
				data: $('#update-form').serialize(),
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
					location.replace('{{ route("admin.navigation.index")}}');
				}
			});
        });
    });

</script>
@endsection