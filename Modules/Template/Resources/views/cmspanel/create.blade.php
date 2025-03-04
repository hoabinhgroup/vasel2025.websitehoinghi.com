@extends('base::cmspanel.layout.dashboard')

@section('title',' - Tạo template mới')

@push('styles')
<style>
	.card-body{
		background: #E5E9EC;
	}
	.content-box{
		margin-top: 20px;
	}
	.nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active{
		border-top: 1px solid #ddd;
		border-left: 1px solid #ddd;
		border-right: 1px solid #ddd;
	}
	.bg-off-white{
		background: #f2f4f6;
	}
	.column-grid-link:hover .grid-bg {
    background: #1ccacc;
    color: #fff;
}
.delete-widget{
	cursor: pointer;
}
.page-title h4 {
    padding: 7px 16px;
    float: left;
}
.page-title .title-button-group {
    float: right;
    margin: 0px 15px 0px 15px;
}

.font-16 {
    font-size: 16px !important;
}
.row-controller {
    flex: 2;
    position: relative;
}
.row-controller .delete {

    cursor: pointer;
    color: #d9534f;
}
.clickable {
    cursor: pointer;
}.
.add-column-drop {
    border: 1px dashed #e2e4e8;
}
.add-column-panel mb-1{
	margin-bottom: 0px !important;
}
.add-column-panel{
	border: 1px dashed #e2e4e8;
}
	.grid-bg {
    background: #f2f4f6;
    transition: .5s all;
	}
	.text-off {
    opacity: 0.6;
}
.widget-column{
	float: left;
}
.row-container {
    flex: 100;
}

.widget-row {
    margin-bottom: 15px;
    padding: 15px;
    display: flex;
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
<h3 class="card-title">Thêm template mới</h3>
      </div>
	<div class="content-body">
	      <div class="row">
 	<div class="col-12">
            <div class="card">

               <div class="card-content collapse show">
                <div class="card-body">

<div id="page-content" class="p-0 clearfix">

    <div class="row clearfix">
        <div class="pl-0 col-md-4" id="widget-container-area">
            @include('template::partials.widget-manager')
        </div>

        <div class="pl-0 col-md-8" id="widget-row-container">
            <div class="panel panel-default">
{{ Form::open(array('route' => 'template.create','id' => 'templateForm')) }}
                <input type="hidden" name="data" id="widgets-data" value="[]"/>
                <input type="hidden" name="id" value="" />
                <input type="hidden" name="title" value="" />
                <input type="hidden" name="color" value="" />

                <div class="page-title clearfix">
                    <div class="row">
                    	<div class="col-md-7 pr-0">
                    		<div class="form-group">
				{{ Form::text('name', null, [
						'id' => 'name',
						'class' => 'form-control',
						'placeholder' => 'Nhập tiêu đề template',
						'style' => 'background:#E5E9EC',
						'data-rule-required' => 'true',
						'data-msg-required' => 'Bắt buộc nhập'
						]) }}
				</div>
                    	</div>
                    	<div class="col-md-5 pl-0 pr-0">

                    <div class="title-button-group">
                        <button type="submit" class="btn btn-primary"><span class="fa fa-check-circle"></span> Lưu</button>
                        <button id="save-and-show-button" class="btn btn-info"><span class="fa fa-check-circle"></span> Lưu và hiển thị</button>
                    </div>
                    	</div>
                    </div><!-- .row -->


                </div>

                <div class="panel-body clearfix">
                    <div class="col-md-12 p-1 bg-off-white pull-right" id="widget-row-area">

                     @include('template::partials.template-rows')
                    </div>

                </div>
		{{ Form::close() }}




            </div>
        </div>
    </div>

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
 <script src="/assets/js/functions.js" type="text/javascript"></script>
 <script src="/assets/js/sortable/sortable.min.js" type="text/javascript"></script>

@include('template::partials.helper_js')
	<script>
		$(function() {
		$("#templateForm").louisForm({
            	onAjaxSuccess: function(result){
	            	console.log('onAjaxSuccess',result);
	            if(result.success){
	            	appAlert.success('ok', {container: 'body', duration: 3000});
	            	window.location.href = '{{ route("template.index") }}';
	            	}
            	},
				onError: function(response) {
					console.log(response);
				},
			 });
			});
	</script>
@endpush
