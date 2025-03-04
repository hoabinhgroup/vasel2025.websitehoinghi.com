@extends('base::cmspanel.layout.dashboard')

@section('title',' - Phân quyền')

@push('styles')
<style>
	.role-list{
		display: block;
		float: left;
		 width: 250px;
		min-height: 250px;
	}
	.role-list li{
		list-style-type: none;
		margin-left: 30px;
		display: block !important;
	}
	.role-list .role-item{
		display: inline-block;
		}
/*	.form-group-list {
		 -moz-column-count: 3;
		 -moz-column-gap: 30px;
		 -webkit-column-count: 3;
		 -webkit-column-gap: 30px;
		 column-count: 3;
		 column-gap: 30px;
		 column-fill: auto;
	}
	*/
	.form-group.form-group-list{
		display: flex;
		flex-wrap: wrap;
		column-gap: 25px;
	}
</style>
     <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pretty-checkbox@3.0/dist/pretty-checkbox.min.css">
@endpush

@section('sidebar')
	@parent
@stop

@section('content')
<div class="content-wrapper">
      <div class="content-header row">

      </div>
      <div class="content-body">
	      <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Phân quyền: {{ $userGroup['name'] }}</h4>
                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                <div class="heading-elements">
                  <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                  </ul>
                </div>
              </div>
              <div class="card-content collapse show">

              <div class="card-body">

@php

 foreach($modules as $module):
 if(File::exists(__DIR__.'/../../'.$module.'/Config/permissions.php'))	{
   $this->mergeConfigFrom(
            __DIR__.'/../../'.$module.'/Config/permissions.php', 'permissions'
        );
      }
  endforeach;

//dd(config('permissions'));

	$configs = config('permissions');
	$list = [];
	foreach($configs as $config):
	if(get_array_value( $config, 'parent_flag')){
		$list[$config['parent_flag']][] = $config;
		}
	endforeach;

@endphp
{{ Form::open(array('route' => 'user-group.setRole','id' => 'roleForm')) }}
	 {!! Form::hidden('id_group', $id) !!}
	 <div class="form-group form-group-list">

	 @foreach($list as $key => $items)
	   <ul class="role-list">
	   <p>
	    <div class="pretty p-default">
        {!! Form::checkbox('role[]', $key .'::' . $key, getPermissionsBySlug($key, $id)) !!}
        <div class="state p-info">
              <label> <strong> {{ ucfirst(str_replace('.index','',$key)) }}  </strong></label>
        </div>
    </div>
	   </p>

	   @foreach($items as $item) 
	      @php 

		  @endphp
	   	  <li class="role-item">
	   	    <div class="pretty p-default">
       {!! Form::checkbox('role[]', $item['flag']. '::' . $item['parent_flag'], getPermissionsBySlug($item['flag'], $id)) !!}
        <div class="state p-info">
             <label> {{ $item['name'] }} </label>
        </div>
			</div>
	   	   </li>
	   @endforeach
	   </ul>
	 @endforeach
	 </div>
	 <div style="clear: both"></div>
	 <div class="form-group">
					{!! Form::button('<i class="icon-check"></i> Lưu', ['type' => 'submit', 'class' => 'btn btn-info'] ) !!}
	</div>
      {{ Form::close() }}
              </div><!--.card-body-->
              </div><!-- .card-content -->
            </div><!-- .card-->
          </div>
	      </div>
      </div>
</div>
@stop

@push('scripts')
   <script type="text/javascript">
	   $(function() {
	$.validator.addMethod("valueNotEquals", function(value, element, arg){
   console.log(element.value);
    return 0 != element.value;
}, "Value must not equal arg.");

    $("#roleForm").louisForm({
            	onAjaxSuccess: function(result){
	            	console.log('onAjaxSuccess',result);
	            if(result.success){
	            	appAlert.success('ok', {container: 'body', duration: 3000});
	            	}
            	},
				onError: function(response) {
					console.log(response);
				},
			});

});
	</script>
@endpush
