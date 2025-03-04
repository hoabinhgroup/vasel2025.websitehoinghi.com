@if (empty($object->toArray()))
<div class="form-group @if ($errors->has('slug')) has-error @endif">
    {!! Form::permalink('slug', old('slug'), 0, $prefix) !!}
    {!! Form::error('slug', $errors) !!}
</div>

@else
@php 
  
$slug = is_object($object->slug) ? $object->slug->key : $object->slug;
$slug_id = is_object($object->slug) ? $object->slug->id : $object->slug_id;
@endphp
<div class="form-group @if ($errors->has('slug')) has-error @endif">
    {!! Form::permalink('slug', $slug, $slug_id, $prefix, Slug::canPreview(get_class($object)) && $object->status != 1) !!}
    {!! Form::error('slug', $errors) !!}
</div>
@endif
<input type="hidden" name="model" value="{{ get_class($object) }}">
