<div class="card">
        <div class="card-header">
                  <h4 class="card-title">{{ __($label) }}</h4>
            
        </div>	
            <div class="card-body d-flex justify-content-between">
               {!! Form::button('<i class="icon-check"></i> Lưu', ['type' => 'submit', 'name' => 'submit', 'class' => 'btn btn-info flex-fill form-control text-white mr-1', 'value' => 'save'] ) !!}
               {!! Form::button('<i class="icon-check"></i> Lưu & Chỉnh sửa', ['type' => 'submit', 'name' => 'submit', 'class' => 'btn btn-success flex-fill form-control text-white', 'value' => 'apply'] ) !!}              
            </div>
       
 </div>
