@extends('base::cmspanel.layout.dashboard')

@push('styles')
<style>
	form > .row > .col-md-3{
		padding-left: 8px;
	}
	.dropdown-language{
		display: none;
	}
	.card-header{
		padding: 15px;
	}
	.card-body{
		padding: 1rem;
	}
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
	button[type="submit"]{
		display: block;
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
	height: auto;
	width: 100%;
	background: #dedede;
	border-radius: 0px;
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
	
	.select-box ul:first-child{
		padding-left: 0px;
	}
	.select-box ul li{
		list-style-type: none;
	}
	#basic-layout-category .card-body{
		padding: 0px !important;
	}
	#a3-category .select-box{
		border: none;
	}
	#search-list-category{
		border-top: none;
		border-left: none;
		border-right: none;
	}
	.image_cover_trash{
		position: absolute;
		bottom: 5px;
		right: 10px;
		font-size: 1.2em;
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

<div id="" class="content-wrapper">
 	<div class="card-header title-bar" style="background: transparent;">
	 	
 			<h1>{{ explode('|', page_title()->getTitle())[0] }}</h1>
    </div>
	<div class="content-body"> 

{!! do_action(BASE_FILTER_CONTENT_TAB, $model, $id ?? null) !!}


@action(BASE_ACTION_META_BOXES, $view, $model)



	</div>
</div>

@stop

@push('scripts')  
<script>
	//$(".content-main-extra").appendTo('form > .row > .col-md-9'); 
	
</script>
 <script src="/assets/js/bootstrap-multiselect.js" type="text/javascript"></script>	
 <script src="/assets/js/chosen.jquery.js" type="text/javascript"></script>	
 <script src="/assets/js/functions.js" type="text/javascript"></script>	
 <script src="/js/form.backend.js?v=1.1" type="text/javascript"></script>	
 <script type="text/javascript">
	 	
	jQuery(function($) {
				
						
					$('.chosen-select').chosen({allow_single_deselect:true,search_contains:true,placeholder_text_multiple:'Chọn danh mục'}); 
			
			
					
	/*	tinymce.init({
    selector: "textarea",
    setup: function (editor) {
        editor.on('change', function () {
            tinymce.triggerSave();
        });
    }
	});		
	*/	
		
					
					
		//tinyMCE.get('textarea').triggerSave();  
			
			//$("#txt-image").parent().closest('.card-body').css('padding','0px');		
		
			});
		
		
			
</script>	
		
@endpush
