@extends('base::cmspanel.layout.dashboard')

@section('title',' - Sửa nhóm')

@push('styles')
<style>
	.content-box{
		margin-top: 20px;
	}
	.nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active{
		border-top: 1px solid #ddd;
		border-left: 1px solid #ddd;
		border-right: 1px solid #ddd;
	}
</style>
<link rel="stylesheet" type="text/css" href="/assets/css/jquery-ui.custom.css">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pretty-checkbox@3.0/dist/pretty-checkbox.min.css">
<link rel="stylesheet" type="text/css" href="/assets/css/chosen.css">
@endpush

@section('sidebar')
	@parent
@stop

@push('scripts')

@endpush

@section('content')
<div class="content-wrapper">
 	<div class="card-header">
<h3 class="card-title">Sửa Nhóm: </h3>
      </div>
	<div class="content-body">
	      <div class="row">
 	<div class="col-12">
            <div class="card">

               <div class="card-content collapse show">
                <div class="card-body">

 <div class="content-box">
			{{ Form::open(array('route' => ['backend.user-group.update', $user['id'] ?? ''],'id' => 'userForm')) }}

			<div class="row">
				<div class="col-md-9">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
				{{ Form::label('name', 'Tên nhóm:') }}
				{{ Form::text('name', $user['name'] ?? '', [
						'class' => 'form-control',
						'data-rule-required' => 'true',
						'data-msg-required' => 'Bắt buộc nhập'
						]) }}
						</div>
					</div>

				</div><!-- .row -->

				<div class="form-group">
					{!! Form::button('<i class="icon-check"></i> Lưu', ['type' => 'submit', 'class' => 'btn btn-info'] ) !!}
				</div>
			</div>
			</div><!-- .row -->

			{{ Form::close() }}
 </div>

                </div><!--.card-body-->
               </div><!-- .card-content -->
            </div>
          </div>
	      </div>
	</div>
</div>
@stop

@push('scripts')

<script>
$(function() {
	$.validator.addMethod("valueNotEquals", function(value, element, arg){
   console.log(element.value);
    return 0 != element.value;
}, "Value must not equal arg.");

    $("#userForm").appForm({
            	onAjaxSuccess: function(result){
	            	console.log('onAjaxSuccess',result);
	            if(result.success){
	            	appAlert.success('ok', {container: 'body', duration: 3000});
	            	window.location.href = '{{ route("user-group.index") }}';
	            	}
            	},
				onError: function(response) {
					console.log(response);
				},
			});

});


	</script>
@endpush
