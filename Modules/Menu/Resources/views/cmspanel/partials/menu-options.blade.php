<style>
	.group-items{
		padding-left: 10px;
	}
	.group-items li{
		list-style-type: none;
	}
</style>
@php	
	
	
@endphp
<div class="panel panel-info">
 	<div class="panel-heading" data-toggle="collapse" data-parent=".accordion-3" href="#a3-{{ $params['namespace'] }}">
 		<h5 class="panel-title">{{ ucfirst($params['label']) }}:</h5>
 	</div>
 	<div id="a3-{{ $params['namespace'] }}" class="panel-collapse collapse in show">
 	<div class="panel-body">
 		<input id="search-list-{{ $params['namespace'] }}" class="form-control search-control" type="text" placeholder="Lọc theo từ khoá" style="width: 100%" autocomplete="off">
<div class="select-box form-control" style="height: 180px;overflow: scroll;width: 100%;margin-bottom: 10px;">
	
@php
	recursiveUl($categories, 0, [], $newMenu);
	echo str_replace('<ul></ul>','',$newMenu);
	unset($newMenu);
@endphp	 
	 
	
</div>	 

	<a onclick="uncheckedall(this);" style="padding: 5px; color: #fff" class="btn btn-sm btn-secondary">
	 <i class="fa fa-circle"></i> Bỏ chọn
	</a>

	<a onclick="importMenuNode('{{ $table }}','{{ $params['namespace'] }}','{{ $params['lang'] }}');" style="padding: 5px; color: #fff" class="btn btn-sm btn-info">
	 <i class="fa fa-plus"></i> Thêm Menu
	</a>
 	</div>
 	</div>
 </div>
 
 
 @include('menu::cmspanel.partials.mustache_template') 
 

	<script>
	 $('#search-list-{{ $params['namespace'] }}').keyup(function() {
        var textboxVal = $(this).val().toLowerCase();
       $(this).parent().find(".group-items li").each(function() {
            var listVal = $(this).text().toLowerCase();
            if(listVal.indexOf(textboxVal) >= 0) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
	 </script>
