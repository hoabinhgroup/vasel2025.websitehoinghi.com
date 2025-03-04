<style>

	.custom-checkbox{
		margin-left: 10px;
	}
	.input-group-addon{
     border-top: 1px solid #00B5B8;
	 border-right: 1px solid #00B5B8;
	 border-bottom: 1px solid #00B5B8;
    padding: 5px 8px;
    display: block;
    }

    label.error{
	    color: red;
	    font-size: 11px;
    }

</style>
@php

@endphp
{{ Form::open(array('route' => ['menunode.update', $id ?? ''],'id' => 'menuNodeForm')) }}

 <div class="modal-body clearfix">

  <div class="form-body">
                        <div class="row">

                          <div class="col-md-12">
                            <div class="form-group">
                {{ Form::label('name', 'Tiêu đề:') }}
				{{ Form::text('name', $title, [
				              'class' => 'form-control border-primary',
							  'data-rule-required' => 'true',
							  'data-msg-required' => 'Bắt buộc nhập'
						]) }}

                            </div>
                          </div>
                        </div>
                       <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                {{ Form::label('name', 'Đường dẫn:') }}
				{{ Form::text('url', $url, [
				              'class' => 'form-control border-primary',
							  'data-rule-required' => 'true',
							  'data-msg-required' => 'Bắt buộc nhập'
						]) }}


                            </div>
                          </div>
                        </div>
						<div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                {{ Form::label('name', 'Icon font:') }}
				{{ Form::text('icon_font', $icon_font, [
				              'class' => 'form-control border-primary'
						]) }}

                            </div>
                          </div>
                        </div>
                         <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                {{ Form::label('name', 'Css Class:') }}
				{{ Form::text('css_class', $css_class, [
				              'class' => 'form-control border-primary'
						]) }}
                            </div>
                          </div>
                        </div>
						   <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                {{  Form::label('name', 'Target:') }}
				{!!

					form_dropdown(
							   	"target",
							   	$data_target,
							   	$target,
							   	"class='select2-size-xs form-control'
							   	id='target'
							   	style='width:100%'
							   	");


				!!}


                            </div>
                          </div>
                        </div>
  <div class="form-actions right">
                        <button type="button" class="btn btn-warning mr-1" data-dismiss="modal">
                          <i class="ft-x"></i> Hủy bỏ
                        </button>
                        <button type="submit" class="btn btn-primary">
                          <i class="fa fa-check-square-o"></i> Lưu
                        </button>
                      </div>
  </div>
 </div>
{{ Form::close() }}



 <script type="text/javascript">
		$(document).ready(function() {


  		$("#menuNodeForm").louisForm({
				onSubmit: function(result) {

            	},
            	onAjaxSuccess: function(result){
	            	console.log(result);
            	},
            	onSuccess: function(result) {
	            		console.log('onSuccess',result);
	            	if(result.success){
		            $(".msg_"+ result.id).html(result.data.title);
	            	 $('.modal').modal('hide');

					 }
				},
				onError: function(response) {
					console.log(response);
				},
			});



});


</script>


