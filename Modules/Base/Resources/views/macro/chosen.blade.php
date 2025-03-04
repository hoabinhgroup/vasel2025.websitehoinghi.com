 <div class="form-group">
				{!! Form::select($name, $data, $selected, $options) !!}
		 </div>			


<script type="text/javascript">

	jQuery(function($) {
				
						
		$('.chosen-select').chosen({allow_single_deselect:true,search_contains:true,placeholder_text_multiple:'Chọn danh muc'}); 
					
						
			});
		
			
</script>
