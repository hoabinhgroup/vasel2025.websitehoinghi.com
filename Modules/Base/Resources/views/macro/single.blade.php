<div class="image-box">
	<input type="hidden" name="{{ $name }}" value="{{ $value }}" class="image-data">
	<div class="preview-image-wrapper">
		<img class="preview_image" width="100%" id="{{ $name }}" src="{{ get_image_url($value, 'featured') }}" />		
		<a class="btn_remove_image" title="{{ __('Base::form.remove_image') }}">
			<i class="fa fa-times"></i>
		</a>
	</div>
	<div class="image-box-actions">
		<a href="#" class="btn_gallery" data-result="{{ $name }}" data-action="select-image">
			{{ __('Base::form.choose_image') }}
		</a>
	</div>
</div>
