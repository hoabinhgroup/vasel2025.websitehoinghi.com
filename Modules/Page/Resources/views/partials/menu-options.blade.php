@if (!empty($pages))  
    <div class="panel panel-info">
 	<div class="panel-heading" data-toggle="collapse" data-parent=".accordion-3" href="#collapsePages">
 		<h5 class="panel-title">{{ __('page::page.menu') }}</h5>
 	</div>
 	<div id="collapsePages" class="panel-collapse collapse in show">
 	<div class="panel-body">
 		<input id="search-list-collapsePages" class="form-control search-control" type="text" placeholder="Lọc theo từ khoá" style="width: 100%" autocomplete="off">
 		<div class="select-box form-control" style="height: 180px;overflow: scroll;width: 100%;margin-bottom: 10px;">
		    <div class="the-box">
	                        {!! $pages !!}
	                       
	    	</div>
		
	</div>	
	
            <div class="btn-group btn-group-devided">
	            <a onclick="uncheckedall(this);" style="padding: 5px; color: #fff" class="btn btn-sm btn-secondary">
		    		<i class="fa fa-circle"></i> Bỏ chọn
		    	</a>
                <a href="#" onclick="importMenuNode(this);" class="btn-add-to-menu btn btn-sm btn-primary">
                    <span class="text"><i class="fa fa-plus"></i> Thêm</span>
                </a>
            </div>
            
 	</div>
 	</div>
    </div>
@endif

