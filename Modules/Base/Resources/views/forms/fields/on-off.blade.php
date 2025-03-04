@if ($showLabel && $showField)
    @if ($options['wrapper'] !== false)
        <div {!! $options['wrapperAttrs'] !!}>
    @endif
@endif



@if ($showField)
	@if ($showLabel && $options['label'] !== false && $options['label_show'])
    {!! Form::customLabel($name, $options['label'], $options['label_attr']) !!}   			
	@endif
	
 @include('base::forms.partials.help_block')
    <div class="pretty p-switch p-fill">
		   {!! Form::checkbox($name, $options['value'], $options['attr']) !!}		
		<div class="state p-success">	
		<label>
			Kích hoạt/ Bỏ kích hoạt 
		</label>
		
        </div>
	</div>

@endif

@include('base::forms.partials.errors')

@if ($showLabel && $showField)
    @if ($options['wrapper'] !== false)
        </div>
    @endif
@endif
