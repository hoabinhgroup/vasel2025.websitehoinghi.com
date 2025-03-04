<br/>
<div class="content-body"> 
	<div class="container">

    @if ($showStart)
        {!! Form::open(array_except($formOptions, ['template'])) !!}
    @endif				
	      <div class="row">
 	<div class="col-md-12">
        
            
					@if ($showFields && $form->hasMainFields())
                <div class="form-group">
                            @foreach ($fields as $key => $field)
                                @if ($field->getName() == $form->getBreakFieldPoint())
                                    @break
                                @else
                                    @unset($fields[$key])
                                @endif
                                @if (!in_array($field->getName(), $exclude))
                                    {!! $field->render() !!}
                                    
                                @endif
                            @endforeach
                        <div class="clearfix"></div>
                </div>
					@endif
           
		
			
            
            
             
         @foreach ($form->getMetaBoxes() as $key => $metaBox)
            {!! $form->getMetaBox($key) !!}
         @endforeach  
            
         {!! $form->getSaveWidget() !!}   
          </div>
 
	      </div>
   @if ($showEnd)
        {!! Form::close() !!}
    @endif
		
	</div><!-- .container -->
</div>
<br/>



@if ($form->getValidatorClass())
    @if ($form->isUseInlineJs())
        {!! $form->renderValidatorJs() !!}
    @else
        @push('scripts')
            {!! $form->renderValidatorJs() !!}
        @endpush
    @endif
    @include('media::partials.media')
    <script>
       "use strict";
       Louis.initMediaIntegrate();
    </script>
@endif


@if(Session::has('success_msg'))
		<script> $(function() { $(document).ready(function(){
			appAlert.success("{{ Session::get('success_msg') }}", {container: 'body', duration: 3000});
		}); }); </script>
	@endif
	
	@if(Session::has('error_msg'))
		<script> $(function() { $(document).ready(function(){
			appAlert.error("{{ Session::get('error_msg') }}", {container: 'body', duration: 5000});
		}); }); </script>
	@endif	
