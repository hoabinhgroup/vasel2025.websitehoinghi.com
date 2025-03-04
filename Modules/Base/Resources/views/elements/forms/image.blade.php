@php
\Assets::add([
      "https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css",
      "https://code.jquery.com/jquery-migrate-3.0.1.js",
      "https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js",
    ]);
   $key = \Session::get('akey');
   @endphp
<div class="image-box">
   <input type="hidden" name="{{ $name }}" id="txt-image-{{ $name }}-hidden" value="{{ $value }}" />
    <div class="preview-image-wrapper @if (!Arr::get($attributes, 'allow_thumb', true)) preview-image-wrapper-not-allow-thumb @endif">

        <img src="{{ get_object_image($value, Arr::get($attributes, 'allow_thumb', true) == true ? 'thumb' : null) }}" alt="{{ __('preview image') }}" id="txt-image-{{ $name }}" class="preview_image" @if (Arr::get($attributes, 'allow_thumb', true)) width="150" @endif>
       <a class="image_cover_trash" onclick="deleteImage('#txt-image-{{ $name }}')" style="display: none;"  class="text-danger"> <i class="fa fa-trash"></i></a>
    </div>

    <div class="image-box-actions">
        <a href="/filemanager/dialog.php?type=1&field_id=txt-image-{{ $name }}&akey={{ $key }}&callback=responsive_filemanager_callback" class="iframe-btn btn_gallery" data-result="{{ $name }}" data-action="{{ $attributes['action'] ?? 'select-image' }}">
            {{ __('base::form.choose_image') }}
        </a>
    </div>
</div>


<script type="text/javascript">
$(document).ready(function(){

    $( ".preview-image-wrapper" ).hover(
  function() {
    $(this).find(".image_cover_trash").show();
  }, function() {
    $(this).find(".image_cover_trash").hide();
  });

     $('.iframe-btn').fancybox({
    'width'		: 900,
    'height'	: 600,
    'type'		: 'iframe',
    'autoScale'    	: false
    });

});

    function deleteImage(object)
    {
       $(object).attr('src','/images/default.png');
       $(object + "-hidden").attr('value','/images/default.png');
    }

    function responsive_filemanager_callback(field_id){

    let url=jQuery('#'+field_id).val();

    url = url.replace(/.*\/\/[^\/]*/, '');
    url = url.replace('/public','');
console.log('url',url);

    $("#"+ field_id).attr('src',url);
    $("#"+ field_id + "-hidden").attr('value',url);
    }

    function close_window() {
    parent.$.fancybox.close();
    }

</script>
