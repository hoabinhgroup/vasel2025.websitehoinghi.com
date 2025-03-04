<div class="card">
        <div class="card-header">
                  <h4 class="card-title">{{ __($label) }}</h4>
            
        </div>	
            <div class="card-body">
               <div class="form-group">				
					<div class="pretty p-switch p-fill">
					{!! Form::checkbox($name, $value, $default_value) !!}		
					<div class="state p-success">
					<label>{{ __('base::form.active') }}</label>
        			</div>
					</div>
			
				</div> 
                           
            </div>
       
</div>
