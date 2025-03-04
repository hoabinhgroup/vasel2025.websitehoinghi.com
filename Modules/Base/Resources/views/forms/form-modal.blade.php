<style>
.modal-dialog{
   max-width: 100%;
}
.form-content-modal{
   padding: 30px 35px;
}
.modal .preview_image{
   width: 200px;
}
</style>
{!! Assets::css() !!}

<div class="content-body">

    @if ($showStart)
        {!! Form::open(\Arr::except($formOptions, ['template'])) !!}
    @endif
	      <div class="row">
 	<div class="col-md-12 form-content-modal">


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

         {!! $form->getSaveButton() !!}
          </div>

	      </div>
   @if ($showEnd)
        {!! Form::close() !!}
    @endif

	</div>



@if ($form->getValidatorClass())
   {!! $form->renderValidatorJs() !!}
@endif

{!! Assets::js() !!}

<script>
$(document).ready(function(){
 
 function openAjaxModal() {
     $("#ajaxModal").modal("show");
 }
 
 $('#louis_media_modal').on('hidden.bs.modal', openAjaxModal);
 
 // Gỡ bỏ sự kiện sau khi nó đã được kích hoạt một lần
 $('#louis_media_modal').one('hidden.bs.modal', function () {
     $(this).off('hidden.bs.modal', openAjaxModal);
 });
});

</script>

@include('media::partials.media')
<script>
   "use strict";
   Louis.initMediaIntegrate();
</script>
