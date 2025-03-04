@php
$permission = $content->screen.'.index';
@endphp

@if(auth()->user()->can((array) $permission))
@widget($content->screen . '::' . $content->widget, [], json_decode($content->config))
@endif
