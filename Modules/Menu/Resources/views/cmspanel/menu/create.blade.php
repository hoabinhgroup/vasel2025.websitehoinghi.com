@extends('base::cmspanel.layout.dashboard')

@section('title',' - Tạo menu')

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

@section('content')
<div class="content-wrapper">
	<div class="content-body"> 
	      <div class="row">
 	<div class="col-12">
            <div class="card">
        <div class="card-header">
	  		<h3 class="card-title">Thêm Menu</h3>
       </div>
              
               <div class="card-content collapse show">
                <div class="card-body">	               
@include('languages::partials.langtabs', 
	['options' => array_merge(
		$langMeta, [
					'route_create' => 'backend.menus.create', 
					'route_edit' => 'backend.menus.edit']
					)])    
<div class="content-box">
			{{ Form::open(array('route' => 'backend.menus.save','id' => 'menuForm')) }}
			@if (isset($_GET['ref_from']))
			{!! Form::hidden('ref_from', $_GET['ref_from']) !!}
			@endif
			@if (isset($_GET['ref_lang']))
			{!! Form::hidden('ref_lang', $_GET['ref_lang']) !!}
			@endif
			<div class="row">
				<div class="col-md-9">
				<div class="form-group">
				{{  Form::label('name', 'Tiêu đề:') }}
				{{ Form::text('name', null, [
						'class' => 'form-control',
						'data-rule-required' => 'true',
						'data-msg-required' => 'Bắt buộc nhập'
						]) }}
				</div>
				<div class="form-group">
				{{ Form::label('slug', 'Đường dẫn:') }}
				{{ Form::text(
					'slug', 
					 null, 
					 	[
					 	  'class' => 'form-control',
					 	  'data-rule-required' => 'true',
					 	  'data-msg-required' => 'Bắt buộc nhập'
					 	  ]) }}
				</div>
				
			</div>
			<div class="col-md-3">
				
				<div class="form-group">	
					{{ Form::label('status', 'Kích hoạt:') }}				
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
 <script src="/assets/js/bootstrap-multiselect.js" type="text/javascript"></script>	
 <script src="/assets/js/chosen.jquery.js" type="text/javascript"></script>	
<script>
$(function() {   
	$.validator.addMethod("valueNotEquals", function(value, element, arg){
   console.log(element.value);
    return 0 != element.value; 
}, "Value must not equal arg.");
	 
    $("#menuForm").appForm({			
            	onAjaxSuccess: function(result){
	            	console.log('onAjaxSuccess',result);
	            if(result.success){	
	            	appAlert.success('ok', {container: 'body', duration: 3000});
	            	window.location.href = '{{ route("menu.index") }}';
	            	}
            	},
				onError: function(response) {
					console.log(response);
				},				
			});
    
});


	</script>		
@endpush
