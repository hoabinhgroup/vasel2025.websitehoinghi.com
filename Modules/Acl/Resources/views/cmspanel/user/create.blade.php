@extends('base::cmspanel.layout.dashboard')

@section('title',' - Tạo trang mới')

@push('styles')
<style>
	.content-box{
		margin-top: 20px;
	}
	.nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active{
		border-top: 1px solid #ddd;
		border-left: 1px solid #ddd;
		border-right: 1px solid #ddd;
	}
</style>
<link rel="stylesheet" type="text/css" href="/assets/css/jquery-ui.custom.css">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pretty-checkbox@3.0/dist/pretty-checkbox.min.css">
<link rel="stylesheet" type="text/css" href="/assets/css/chosen.css">
@endpush

@section('sidebar')
	@parent
@stop

@push('scripts')

@endpush

@section('content')
<div class="content-wrapper">
 	<div class="card-header">
<h3 class="card-title">Thêm user mới</h3>
      </div>
	<div class="content-body">
	      <div class="row">
 	<div class="col-12">
            <div class="card">

               <div class="card-content collapse show">
                <div class="card-body">

 <div class="content-box">
			{{ Form::open(array('route' => 'backend.user.save','id' => 'userForm')) }}

			<div class="row">
				<div class="col-md-9">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
				{{ Form::label('name', 'Username:') }}
				{{ Form::text('name', null, [
						'class' => 'form-control',
						'data-rule-required' => 'true',
						'data-msg-required' => 'Bắt buộc nhập'
						]) }}
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
				{{ Form::label('email', 'Email:') }}
				{{ Form::text(
					'email',
					 null,
					 	[
					 	  'class' => 'form-control',
					 	  'data-rule-required' => 'true',
					 	  'data-msg-required' => 'Bắt buộc nhập'
					 	  ]) }}
					 	</div>
					</div>
				</div><!-- .row -->

				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
				{{ Form::label('first_name', 'First Name:') }}
				{{ Form::text('first_name', null, [
						'class' => 'form-control',
						]) }}
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
				{{ Form::label('last_name', 'Last Name:') }}
				{{ Form::text(
					'last_name',
					 null,
					 	[
					 	  'class' => 'form-control',
					 	  ]) }}
					 	</div>
					</div>
				</div><!-- .row -->

				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
				{{ Form::label('phone', 'Điện thoại:') }}
				{{ Form::text('phone', null, [
						'class' => 'form-control',
						]) }}
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
				{{ Form::label('gender', 'Giới tính:') }}
				{!! Form::select('gender',
						[
							'1' => 'Nam',
						    '2'=>'Nữ'],
						    null,
						    [
						    	'class'=>'form-control',
						    	'placeholder'=>'Chọn giới tính']) !!}
					 	</div>
					</div>
				</div><!-- .row -->

				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
				{{ Form::label('skype', 'Skype:') }}
				{{ Form::text('skype', null, [
						'class' => 'form-control',
						]) }}
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
				{{ Form::label('facebook', 'Facebook:') }}
				{{ Form::text(
					'facebook',
					 null,
					 	[
					 	  'class' => 'form-control',
					 	  ]) }}
					 	</div>
					</div>
				</div><!-- .row -->



				<div class="form-group">
				{{  Form::label('interest', 'Về bản thân:') }}
				{!! Form::tinyMCE(
					  'interest',
					   null,
					      [
					      	'class'=>'form-control'
					      	]) !!}

				</div>
			</div>
			<div class="col-md-3">
				<div class="form-group">
				{{  Form::label('id_group', 'Thuộc nhóm:') }}
				{!! Form::select('id_group',
						[
							'1' => 'Administrator',
						    '2'=>'Biên tập viên'],
						    null,
						    [
						    	'class'=>'form-control',
						    	'placeholder'=>'Chọn nhóm']) !!}
				</div>
				<div class="form-group">
					<label for="">Kích hoạt</label><br/>
					<div class="pretty p-switch p-fill">
					{!! Form::checkbox('status', 1, true) !!}
					<div class="state">
					<label>Kích hoạt/ Bỏ kích hoạt</label>
        			</div>
				</div>

				</div>


				<div class="form-group">
					{!! Form::button('<i class="icon-check"></i> Lưu', ['type' => 'submit', 'class' => 'btn btn-info'] ) !!}
				</div>
			</div>
			</div><!-- .row -->

			{{ Form::close() }}
 </div>

                </div><!--.card-body-->
               </div><!-- .card-content -->
            </div>
          </div>
	      </div>
	</div>
</div>
@stop

@push('scripts')
 <script src="/editor/tinymce/tinymce.min.js"></script>
 <script src="/assets/js/bootstrap-multiselect.js" type="text/javascript"></script>
 <script src="/assets/js/chosen.jquery.js" type="text/javascript"></script>

<script type="text/javascript">
	jQuery(function($) {


					$('.chosen-select').chosen({allow_single_deselect:true,search_contains:true,placeholder_text_multiple:'Chọn địa điểm'});
					//resize the chosen on window resize

					$(window)
					.off('resize.chosen')
					.on('resize.chosen', function() {
						$('.chosen-select').each(function() {
							 var $this = $(this);
							 $this.next().css({'width': $this.parent().width()});
						})
					}).trigger('resize.chosen');
					//resize chosen on sidebar collapse/expand
					$(document).on('settings.ace.chosen', function(e, event_name, event_val) {
						if(event_name != 'sidebar_collapsed') return;
						$('.chosen-select').each(function() {
							 var $this = $(this);
							 $this.next().css({'width': $this.parent().width()});
						})
					});


					$('#chosen-multiple-style .btn').on('click', function(e){
						var target = $(this).find('input[type=radio]');
						var which = parseInt(target.val());
						if(which == 2) $('#form-field-select-4').addClass('tag-input-style');
						 else $('#form-field-select-4').removeClass('tag-input-style');
					});



			});


</script>

<script>
$(function() {
	$.validator.addMethod("valueNotEquals", function(value, element, arg){
   console.log(element.value);
    return 0 != element.value;
}, "Value must not equal arg.");

    $("#userForm").appForm({
            	onAjaxSuccess: function(result){
	            	console.log('onAjaxSuccess',result);
	            if(result.success){
	            	appAlert.success('ok', {container: 'body', duration: 3000});
	            	window.location.href = '{{ route("user.index") }}';
	            	}
            	},
				onError: function(response) {
					console.log(response);
				},
			});

});


	</script>
@endpush
