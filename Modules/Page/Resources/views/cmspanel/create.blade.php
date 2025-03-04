@extends('base::cmspanel.layout.dashboard')

@section('title',' - Tạo trang mới')

@push('styles')
<style>
	.content-box{
		margin-top: 20px;
	}
	.nav-tabs{
		border-bottom: none !important;
	}
	.nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active{
		border-top: 1px solid #ddd;
		border-left: 1px solid #ddd;
		border-right: 1px solid #ddd;
	}
	.row-container {
    flex: 100;
	}
	.add-column-drop {
    border: 1px dashed #e2e4e8;
	}
	.p15 {
    padding: 15px;
	}
	#txt-image{ 
	height: 110px;
	width: 100%;
	background: #dedede;
	border-radius: 15px;
	border: none;
	}
	.title-bar {
    font-size: 28px;
    font-weight: 500;
    margin-bottom: 0;
    padding-left: 0px;
	}
	.tox-tinymce{
		margin: 10px 1px;
		
	}
</style>

<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pretty-checkbox@3.0/dist/pretty-checkbox.min.css">
@endpush

@section('sidebar')
	@parent
@stop

@push('scripts')  

@endpush

@section('content')

<!--@widget('page::recentNews')-->
<div id="" class="content-wrapper">
 	<div class="card-header title-bar" style="background: transparent;">
 			<h1>Thêm trang mới</h1>
      </div>
	<div class="content-body"> 
	@if(is_plugin_active('Languages'))
	@include('languages::partials.langtabs', 
	['options' => array_merge(
		$langMeta, [
					'route_create' => 'backend.page.create', 
					'route_edit' => 'backend.page.edit']
					)])
	@endif				
	{{ Form::open(array('route' => 'backend.page.save','id' => 'pageForm')) }}				
	      <div class="row">
 	<div class="col-md-9">
            <div class="card">

               <div class="card-content collapse show">
                <div class="card-body">	               


 <div class="content-box">   
			
			@if (isset($_GET['ref_from']))
			{!! Form::hidden('ref_from', $_GET['ref_from']) !!}
			@endif
			@if (isset($_GET['ref_lang']))
			{!! Form::hidden('ref_lang', $_GET['ref_lang']) !!}
			@endif
			<div class="row">
				<div class="col-md-12">
				<div class="form-group">
				{{ Form::label('name', 'Tiêu đề:') }}
				{{ Form::text('name', null, [
						'id' => 'name',
						'class' => 'form-control',
						'onkeyup' => 'ChangeToSlug()',
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
				<div class="form-group">
				{{  Form::label('content', 'Miêu tả:') }}
				{!! Form::tinyMCE(
					  'content',
					   null, 
					      [
					      	'class'=>'form-control'
					      	]) !!}
				
				</div>
			</div>
		
			</div><!-- .row -->

			
 </div>

                </div><!--.card-body-->
               </div><!-- .card-content -->
            </div>
          </div>
 	<div class="col-md-3">
	 
	 
	 
	 <div class="card">
        <div class="card-header">
                  <h4 class="card-title" id="basic-layout-colored-form-control">Publish</h4>
                  <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
        </div>
        <div class="card-content collapse show">
            <div class="card-body">
               <div class="form-group">				
					<div class="pretty p-switch p-fill">
					{!! Form::checkbox('status', 1, true) !!}		
					<div class="state">
					<label>Kích hoạt</label>
        			</div>
					</div>
			
				</div> 
               <div class="form-group">
					{!! Form::button('<i class="icon-check"></i> Lưu', ['type' => 'submit', 'class' => 'btn btn-info'] ) !!}
				
					</div>               
            </div>
        </div>
     </div>
     
     <div class="card">
             <div class="card-header">
                       <h4 class="card-title" id="basic-layout-colored-form-control">Template</h4>
                    
             </div>
             <div class="card-content collapse show">
                 <div class="card-body">
                     <div class="form-group">
				{!! Form::chosen('template', Template::select(['name']), NULL) !!}
					 </div>			
     			                
                 </div>
             </div>
          </div>
		  
		  <div class="card">
		          <div class="card-header">
		                    <h4 class="card-title" id="basic-layout-colored-form-control">Cover</h4>
		                 
		          </div>
		          <div class="card-content collapse show">
		              <div class="card-body">
		                <div class="form-group">
						{!! Form::cover('image') !!}
					
						</div>	                
		              </div>
		          </div>
		       </div>

				
 	</div>
	      </div>
	      {{ Form::close() }}
	</div>
</div>
@stop

@push('scripts')  
<script src="/assets/js/functions.js" type="text/javascript"></script>
<script>
$(function() {   
	$.validator.addMethod("valueNotEquals", function(value, element, arg){
   console.log(element.value);
    return 0 != element.value; 
}, "Value must not equal arg.");
	 
    $("#pageForm").appForm({			
            	onAjaxSuccess: function(result){
	            	console.log('onAjaxSuccess',result);
	            if(result.success){	
	            	appAlert.success('ok', {container: 'body', duration: 3000});
	            	window.location.href = '{{ route("page.index") }}';
	            	}
            	},
				onError: function(response) {
					console.log(response);
				},				
			});
    
});


	</script>		
@endpush
