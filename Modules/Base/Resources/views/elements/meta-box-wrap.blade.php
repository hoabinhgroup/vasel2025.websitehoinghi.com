<div class="card meta-boxes">
    <div id="{{ $box['id'] }}" class="card-header widget meta-boxes">
     <h4 class="card-title widget-title"><label for="tag" class="control-label">{{ $box['title'] }}</label></h4>
    </div>
    <div class="card-body widget-body">
		<div class="form-group">	
			{!! $callback !!}	
		</div>
    </div>
</div>
