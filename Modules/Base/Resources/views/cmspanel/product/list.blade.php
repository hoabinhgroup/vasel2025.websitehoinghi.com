@extends('cmspanel/layout/dashboard')

@section('title',' - Danh sách Bài viết')

@push('styles')
     <link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/forms/toggle/switchery.min.css">
     <link rel="stylesheet" type="text/css" href="/app-assets/css/plugins/forms/switch.css">
@endpush

@section('sidebar')
	@parent
@stop

@section('content')
<div class="content-wrapper">
      <div class="content-header row">

      </div>
      <div class="content-body">
	      <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Danh sách bài viết</h4>
                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                <div class="heading-elements">
                  <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                  </ul>
                </div>
              </div>
              <div class="card-content collapse show">

              <div class="card-body">
	      <div class="row">

	      	 <div class="col-sm-12">
			                   <div class="row mb-1">

			                   <div class="col-md-2">
				                   <a href="{!! route('cmspanel.product.getAdd') !!}" class="btn btn-success mr-1" title="Thêm danh mục"  ><i class="icon-plus font-weight-bold"></i> Thêm</a>
			                   </div>
			                   <div class="col-md-5">
			                   	&nbsp;
			                   </div>
			              <div class="col-md-5">
			              	<form action="/cmspanel/product" id="form-search" method="post" class="form-search">
	              	  <div class="input-group">
                        <input type="text" class="form-control" name="keyword" id="keyword" placeholder="Gõ từ khóa cần tìm">
                        <input type="hidden" name="filter_select" id="filter_select" value="1">
                        <div class="input-group-append">
                          <button type="submit" class="btn btn-primary"><i class="icon-magnifier font-weight-bold"></i>  <span id="search-category-name">Tìm kiếm</span></button>

                        </div>
                      </div>
			  	</form>
			              </div>

			                   </div><!-- .row -->
		                   </div>
	      </div><!-- .row -->

	 <div class="table-responsive">
	     <div class="dataTables_wrapper dt-bootstrap4">
	               	<div class="row">
		               	<div class="col-md-5">
		               	@if(Session::has("flash_message"))
	             <div class="alert alert-icon-left alert-success alert-dismissible mb-2" role="alert">
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                          </button>

                  {!! Session::get("flash_message") !!}

                  </div>
                   @endif
		               	</div>


	               	</div><!-- .row -->

	                 <div class="row">

			        <div class="col-sm-12">
                  <table id="data-table" class="table table-customer table-bordered table-striped dataTable">
                    <thead>
                      <tr>
	                    <th>ID</th>

                        <th class="sorting text-center" data-col="customer_card_code">Tên bài viết</th>
                        <th class="sorting text-center" data-col="customer_name">Đường dẫn</th>
                        <th class="text-center">Tạo lúc</th>
                        <th class="text-center">Chỉnh sửa lúc</th>
                        <th class="text-center">Người tạo</th>
                        <th class="text-center">Lượt xem</th>
                        <th class="text-center">Trạng thái</th>
                        <th class="text-center">Ưa chuộng</th>
                        <th class="text-center">Sửa </th>
                        <th class="text-center">Xóa</th>

                       <th><div class="d-inline-block custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input bg-info" id="ck_All">
                        <label class="custom-control-label" for="ck_All"></label>
                      </div></th>
                      </tr>
                    </thead>
                    <tbody id="data-list">
	                    @foreach($data as $item)
                     	<tr>
	                     	<td class="text-center"> {!! $item['id'] !!}</td>
	                     	<td class="text-left"> {!! $item['name'] !!}</td>
	                     	<td class="text-left"> {!! $item['ident'] !!}</td>
	                     	<td class="text-left"> {!! date('d/m/Y',$item['created_at']) !!}</td>
	                     	<td class="text-left"> {!! $item['updated_at'] !!}</td>
	                     	<td class="text-left">
		                     		<?php
                         $author = DB::table("users")
                           ->select("name")
                           ->where("id", $item["author"])
                           ->first();
                         echo $author->name;
                         ?>
	                     	</td>
	                     	<td class="text-left"> {!! $item['views'] !!}</td>


	                     	<td class="text-center">
	          <div class="form-group">
                      <input name="status" type="checkbox" data-size="sm" class="switchery" value="1" {!! (($item['status'] == 1)?' checked': '') !!} />
                      <label for="switcherySize1" class="font-medium-2 ml-1"></label>

                    </div>
	                     	</td>

	                     	<td class="text-center">
	          <div class="form-group">
                      <input name="status" type="checkbox" data-size="sm" class="switchery" value="1" {!! (($item['featured'] == 1)?' checked': '') !!} />
                      <label for="switcherySize1" class="font-medium-2 ml-1"></label>

                    </div>
	                     	</td>

	                     	<td class="text-center">
		                     	<i class="fa fa-pencil fa-fw"></i><a href="{!! route('cmspanel.product.getEdit',$item['id'] ) !!}">Sửa</a>
	                     	</td>
	                     	<td class="text-center">
		                     	<i class="fa fa-trash-o fa-fw"></i><a href="{!! route('cmspanel.product.getDelete', $item['id']) !!}">Xóa</a>
	                     	</td>
	                     	<td class="text-center">
		                     	<div class="d-inline-block custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input bg-info" name="table_checkbox[]" id="colorCheck{!! $item['id'] !!}">
                        <label class="custom-control-label" for="colorCheck4643"></label>
                      </div></td>
                     	</tr>
                     	@endforeach
                    </tbody>


                  </table>

                     <div class="row" style="margin-left: 0px; margin-right: 0px; margin-top: 15px;">

                 <div class="col-md-1">
	                   <div class="row">
                           <select name="limit" id="limit" class = "select2 form-control"style = "width: 100%"id = "limit"><option label="Hiển thị" value="0" selected="selected">Hiển thị</option><option label="15" value="15"  selected="selected">+15</option><option label="25" value="25" >+25</option><option label="50" value="50" >+50</option><option label="100" value="100" >+100</option></select>	                   </div>

                 </div>

                <div class="col-sm-4 col-md-4">

	                 <div class="dataTables_info" role="status" aria-live="polite">Từ <span class="start_number"> </span> đến <span class="current_number"> </span> / tổng số <span class="total_number"> </span> </div>

	               </div>
                <div class="col-sm-7 col-md-7" style="padding-right: 0px;">
                     <div id="paging" class="paging" style="float: right" class="dataTables_paginate pull-right">
    				</div>
                </div>
               		 </div><!-- .row -->
		                   </div>
                 	 </div>


		 </div>
     </div>

              </div><!--.card-body-->
              </div><!-- .card-content -->
            </div><!-- .card-->
          </div>
	      </div>
      </div>
</div>
@stop

@push('scripts')
     <script src="/public/app-assets/vendors/js/forms/toggle/bootstrap-checkbox.min.js"
  type="text/javascript"></script>
  <script src="/public/app-assets/vendors/js/forms/toggle/switchery.min.js" type="text/javascript"></script>
   <script src="/public/app-assets/js/scripts/forms/switch.js" type="text/javascript"></script>
@endpush
