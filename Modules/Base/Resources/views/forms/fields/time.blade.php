@if ($showLabel && $showField)
@if ($options['wrapper'] !== false)
	<div {!! $options['wrapperAttrs'] !!}>
@endif
@endif

@if ($showLabel && $options['label'] !== false && $options['label_show'])
{!! Form::customLabel($name, $options['label'], $options['label_attr']) !!}
@endif
@if ($showField)
<div class="input-group">
	{!! Form::text($name, $options['value'] ?? now(config('app.timezone'))->format('d/m/Y H:i:s'), array_merge($options['attr'], ['class' => Arr::get($options['attr'], 'class', '') . str_replace(Arr::get($options['attr'], 'class'), '', ' form-control date')])) !!}
	<div class="input-group-append">
	<span class="input-group-text">
	  <span class="fa fa-calendar"></span>
	</span>
  </div>
</div>
<script>
$(document).ready(function(){
	$('.date').datetimepicker({
		  minDate: new Date(),
		  format: 'DD/MM/YYYY HH:mm:ss',
		  ignoreReadonly: true
	  });
});

</script>
@include('base::forms.partials.help_block')
@endif

@include('base::forms.partials.errors')

@if ($showLabel && $showField)
@if ($options['wrapper'] !== false)
	</div>
@endif
@endif
