  @php

  $key = session()->get('akey');
  @endphp
   <div id="cover-element-{{ $name }}" class="form-group" style="margin-bottom: 0px;">
			<a href="/filemanager/dialog.php?type=1&field_id={{ $name }}&akey={{ $key }}&callback=responsive_filemanager_callback_{{ $name }}" class="iframe-btn mt-1" id="upload_cover_{{ $name }}">
     <input type="hidden" name="{{ $name }}" id="{{ $name }}-hidden" value="{{ $value }}" />
     <img width="100%" id="{{ $name }}" src="{{ $value }}" />
     </a>
    <a class="image_cover_trash_{{ $name }}" onclick="deleteImage()" style="display: none;" class="text-danger"> <i class="fa fa-trash"></i></a>

						</div>


<script type="text/javascript">
$(document).ready(function(){

	$( "#cover-element-{{ $name }} a" ).hover(
  function() {
    $('.image_cover_trash_{{ $name }}').show();
	  }, function() {
    $('.image_cover_trash_{{ $name }}').hide();
  });

	 $('.iframe-btn').fancybox({
	'width'		: 900,
	'height'	: 600,
	'type'		: 'iframe',
    'autoScale'    	: false
    });

});

    function deleteImage()
    {
	   $(`#{{ $name }}`).attr('src','/images/default.png');
	   $(`#{{ $name }}-hidden`).attr('value','/images/default.png');
    }

    function responsive_filemanager_callback_{{ $name }}(field_id){
	console.log('field_id',field_id);
	var url=jQuery('#'+field_id).val();
	url = url.replace(/.*\/\/[^\/]*/, '');
	$("#"+field_id).attr('src',url);
	$(`#${field_id}-hidden`).attr('value',url);
	}

	function close_window() {
    parent.$.fancybox.close();
	}

</script>

