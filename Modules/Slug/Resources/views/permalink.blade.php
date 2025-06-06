@php
$prefix = apply_filters(FILTER_SLUG_PREFIX, $prefix);
$value = $value ? $value : old('slug');
$endingURL = config('slug.public_single_ending_url');
$previewURL = str_replace('--slug--', $value, url($prefix) . '/' . config('slug.pattern')) . $endingURL . (Auth::user() && $preview ? '?preview=true' : '');

@endphp

<div id="edit-slug-box" dir="ltr" @if (empty($value)) class="hidden" @endif>
@if (in_array(Route::currentRouteName(), ['page.create', 'page.edit']) && BaseHelper::isHomepage(Route::current()->parameter('page')))

    <label class="control-label" for="current-slug">{{ trans('base::form.permalink') }}:</label>
    <span id="sample-permalink">
        <a class="permalink" target="_blank" href="{{ url('') }}">
            <span class="default-slug">{{ url('') }}</span>
        </a>
    </span>
@else
    <label class="control-label required" for="current-slug">{{ trans('base::form.permalink') }}:</label>
    <span id="sample-permalink" class="d-inline-block">
        <a class="permalink" target="_blank" href="{{ $previewURL }}">
            <span class="default-slug">{{ url($prefix) }}/<span id="editable-post-name">{{ $value }}</span>{{ $endingURL }}</span>
        </a>
    </span>
@endif
    <span id="edit-slug-buttons">
        <button type="button" class="btn btn-secondary" id="change_slug">{{ trans('base::form.edit') }}</button>
        <button type="button" class="save btn btn-secondary" id="btn-ok">{{ trans('base::form.ok') }}</button>
        <button type="button" class="cancel button-link">{{ trans('base::form.cancel') }}</button>
        @if (Auth::user() && $preview)
            <a style="margin-left: 0px;" class="btn btn-info btn-preview" target="_blank" href="{{ $previewURL }}">{{ trans('slug::slug.preview') }}</a>
        @endif
    </span>

</div>
<input type="hidden" id="current-slug" name="{{ $name }}" value="{{ $value }}">
<div data-url="{{ route('slug.create') }}" data-view="{{ rtrim(str_replace('--slug--', '', url($prefix) . '/' . config('slug.pattern')), '/') . '/' }}" id="slug_id" data-id="{{ $id ? $id : 0 }}"></div>
<input type="hidden" name="slug_id" value="{{ $id ? $id : 0 }}">
