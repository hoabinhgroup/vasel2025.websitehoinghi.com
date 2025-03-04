<div class="ui-select-wrapper form-group">
@php
    Arr::set($selectAttributes, 'class', Arr::get($selectAttributes, 'class') . ' ui-select');
@endphp
{!! Form::select($name, $list, $selected, $selectAttributes, $optionsAttributes, $optgroupsAttributes) !!}


</div>
