@extends('base::cmspanel.layout.dashboard')


@push('styles')
<link rel="stylesheet" type="text/css" href="/css/select2.min.css">
<style>
	form > .row > .col-md-3{
		padding-left: 8px;
	}
	
	.modal-dialog.modal-full{
		max-width: 100%;
	}

	.card.meta-boxes .form-group{
		margin-bottom: 0px;
	}
	.dropdown-language{
		display: none;
	}
	.card-header{
		padding: 15px;
		border-bottom: 1px solid #eee;
		background: none;
		padding-bottom: 6px;
	}
	.card-body{
		padding: 1rem;
	}
	.content-box{
		margin-top: 20px;
	}
    .dropdown-menu.show{
        top: 34px !important;
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

@push('scripts')

@endpush

@section('content')
<div class="content-body">


@php

@endphp
{!! do_action(BASE_FILTER_CONTENT_TAB, $model, $id ?? null) !!}


    @if ($showStart)
        {!! Form::open(\Arr::except($formOptions, ['template'])) !!}
    @endif

	      <div class="row">
 	<div class="col-md-9">
            <div class="card">


                <div class="card-body">

			<div class="row">
				<div class="col-md-12">
					@if ($showFields && $form->hasMainFields())
                <div class="form-group">
                            @foreach ($fields as $key => $field)
                                @if ($field->getName() == $form->getBreakFieldPoint())
                                    @break
                                @else
                                    @unset($fields[$key])
                                @endif
                                @if (!in_array($field->getName(), $exclude))
                                    {!! $field->render() !!}
                                    @if ($field->getName() == 'name' && defined('BASE_FILTER_SLUG_AREA'))
                                        {!! apply_filters(BASE_FILTER_SLUG_AREA, $form->getModel()) !!}
                                    @endif

                                @endif
                            @endforeach
                        <div class="clearfix"></div>
                </div>
					@endif


			</div>

			</div><!-- .row -->


                </div><!--.card-body-->

            </div>


         @foreach ($form->getMetaBoxes() as $key => $metaBox)
            {!! $form->getMetaBox($key) !!}
         @endforeach


       	@php do_action(BASE_ACTION_META_BOXES, 'advanced', $form->getModel()) @endphp

          </div>
 	<div class="col-md-3">

	 {!! $form->getActionButtons() !!}

	  @php do_action(BASE_ACTION_META_BOXES, 'top', $form->getModel()) @endphp

     @foreach ($fields as $field)
                @if (!in_array($field->getName(), $exclude))

                    <div class="card meta-boxes">
                        <div class="card-header">
                            <h4 class="card-title">{!! Form::customLabel($field->getName(), $field->getOption('label'), $field->getOption('label_attr')) !!}</h4>
                        </div>
                        <div class="card-body">
							<div class="form-group">
                            {!! $field->render([], in_array($field->getType(), ['radio', 'checkbox'])) !!}
							</div>
                        </div>
                    </div>
                @endif
            @endforeach

	  @php do_action(BASE_ACTION_META_BOXES, 'side', $form->getModel()) @endphp

 	</div>
	      </div>
   @if ($showEnd)
        {!! Form::close() !!}
    @endif




	</div>

@stop

@push('scripts')


<script>
	//$(".content-main-extra").appendTo('form > .row > .col-md-9');

</script>


 <!-- Laravel Javascript Validation -->
<!--<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>-->
<script type="text/javascript" src="{{ asset('/js/js-validation.js')}}"></script>

 <script src="/assets/js/bootstrap-multiselect.js" type="text/javascript"></script>
 <script src="/assets/js/chosen.jquery.js" type="text/javascript"></script>
 <script src="/assets/js/functions.js" type="text/javascript"></script>
<script src="/js/select2.min.js"></script>
 <script src="/js/form.backend.js?v=1.1" type="text/javascript"></script>
 <script type="text/javascript">

	jQuery(function($) {
                    $('.select2').select2();

					$('.chosen-select').chosen({allow_single_deselect:true,search_contains:true,placeholder_text_multiple:'Chọn danh mục'});

			});

		$("#cover-element").parent().parent().css('padding', '0px');

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

			//});



</script>



@if ($form->getValidatorClass())
    @if ($form->isUseInlineJs())
        {!! $form->renderValidatorJs() !!}
		
    @else
        @push('scripts')
            {!! $form->renderValidatorJs() !!}
        @endpush
    @endif
	@include('media::partials.media')
	<script>
		"use strict";
		Louis.initMediaIntegrate();
	</script>
@endif


@if(Session::has('success_msg'))
		<script> $(function() { $(document).ready(function(){
			appAlert.success("{{ Session::get('success_msg') }}", {container: 'body', duration: 3000});
		}); }); </script>
	@endif

	@if(Session::has('error_msg'))
		<script> $(function() { $(document).ready(function(){
			appAlert.error("{{ Session::get('error_msg') }}", {container: 'body', duration: 5000});
		}); }); </script>
	@endif

@endpush
