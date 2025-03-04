<div class="attachment-wrapper-{{ $title }}">
	<input type="hidden" name="{{ $name }}" value="{{ $value }}" class="attachment-url">
	<div class="attachment-details"><a target="_blank" href="/{{ $value }}">{{ $value }}</a></div>
	<a href="#" class="btn_attach btn btn-danger" data-result="{{ $name }}" data-action="attachment">
		<i class="fa fa-paperclip"></i> {{ __('Choose file') }}
	</a>
</div>