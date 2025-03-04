@if ($showLabel && $showField)
    @if ($options['wrapper'] !== false)
        <div {!! $options['wrapperAttrs'] !!}>
    @endif
@endif

@if ($showLabel && $options['label'] !== false && $options['label_show'])
    {!! Form::customLabel($name, $options['label'], $options['label_attr']) !!}
@endif
<div class="form-group">
<span class="editor-action-item action-show-hide-editor">
    <button class="btn btn-primary show-hide-editor-btn" type="button" data-result="{{ $options['id'] }}">Ẩn / hiện trình soạn thảo</button>
</span>
<span class="editor-action-item">
    <a href="#" class="btn_gallery btn btn-primary"
       data-result="{{ $options['id'] }}"
       data-multiple="true"
       data-action="media-insert-{{ setting('editor') }}">
        <i class="far fa-image"></i> Thêm tệp tin
    </a>
</span>
</div>
@php

@endphp

@if ($showField)
    @include('base::partial.editor', $options)
    @if(setting('editor') == 'ckeditor')
    {!! Form::ckeditor($name, htmlentities($options['value']), $options['attr'], $options['type'] ?? '') !!}
    @else
    {!! Form::tinyMCE($name, htmlentities($options['value']), $options['attr'], $options['type'] ?? '') !!}
    @endif
    @include('base::forms.partials.help_block')
@endif

@include('base::forms.partials.errors')

@if ($showLabel && $showField)
    @if ($options['wrapper'] !== false)
        </div>
    @endif
@endif
