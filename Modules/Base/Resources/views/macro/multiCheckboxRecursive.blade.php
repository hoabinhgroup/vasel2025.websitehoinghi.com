			@php 

           $select =  arrayToObject($source);
           $select = (array) $select;
		   
		   @endphp       
               <div class="panel panel-info">
 	
 	<div id="a3-category" class="panel-collapse collapse in show">
 	<div class="panel-body" style="padding: 0px 5px;">
 		<input id="search-list-category" class="form-control search-control search-list-category" type="text" placeholder="Lọc theo từ khoá" style="width: 100%" autocomplete="off">
<div class="select-box form-control" style="height: 180px;overflow: scroll;width: 100%;margin-bottom: 10px;">
	
{!!
	recursiveCategory($select, 0, $default_value, $newMenu, $name);
	echo str_replace('<ul></ul>','',$newMenu);
	unset($newMenu);
!!}
	 
	
</div>	 

 	</div>
 	</div>
 </div>      
                     
					 
