@extends('base::cmspanel.layout.dashboard')

@section('title',' - Dashboard')

@section('content')

	 <style>
	 .content-header-left{
		 display: none;
	 }
	 </style>
      <div class="content-header row">
      </div>
      <div class="content-body">



	@php
	   //page_title()->setTitle('Bảng điều khiển');
	   $template = app(\Modules\Template\Repositories\TemplateInterface::class)->find(1);
	   $elements = json_decode($template->data);

	  $template = make_template($elements);

	@endphp

	{!! $template !!}

      </div>

    @stop


    @push('scripts')

   @endpush
