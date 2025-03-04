@extends('theme::layouts.master')

@section('title', $page->name)

@section('content')

<div class="container-fluid">
        <style>
	#conf_pre{
		margin-top: 20px;
	}
	#conf_pre tr td{
		padding: 15px !important;
	}
</style>
        <div id="sub_line"></div>

        <div id="sub_wrap">
            <div id="sub_category">
                <span class="txt_color_1">Trang chủ &gt; {{ $page->name }}</span>
            </div>

            <div id="sub_title"> {{ $page->name }}  </div>
        </div>

        <div id="sub_line2"></div>

        <div id="sub_wrap">
            <div id="sub_contarea">
                <div id="sub_txtarea">
	                
		             {!! $template !!} 
	               
	            </div>
            </div>
        </div>

        <div>
          
      
   </div>
</div>



     

@endsection
