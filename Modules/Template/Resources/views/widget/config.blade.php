 <script src="/editor/tinymce/tinymce.min.js"></script>


   <script>
	 
	tinymce.init({
    selector: "textarea",
    setup: function (editor) {
        editor.on('change', function () {
            tinymce.triggerSave();
        });
    }
});

function getFormData($form){
    var unindexed_array = $form.serializeArray();
    var indexed_array = {};

    $.map(unindexed_array, function(n, i){
        indexed_array[n['name']] = n['value'];
    });

    return indexed_array;
}

	$(document).ready(function(){
	
		
		$("#saveConfig").click(function(e) {
            e.preventDefault();        //prevent form to submit
            var formData= $(this).closest('form').serializeArray();  
            //serializeRemove(formData, '_token');      //fetch form data
              formData = formData.filter( function( item ) {
               return item.name != '_token';
           });
         // console.log('getFormData',getFormData($(this).closest('form')));
         // console.log('data_element',"#element_{{ $data['element'] }}");
          console.log('formData',formData);
          console.log('formData-json',JSON.stringify(formData));
          $("div[id='element_{{ $data['element'] }}']").attr("data-config", JSON.stringify(formData));
          $("a[data-post-element='{{ $data['element'] }}']").attr("data-post-config", JSON.stringify(formData)); 
          saveWidgetPosition();
          $("#ajaxModal").modal('hide');
         // console.log('text',tinymce.get('{{ $data["widget"] }}').getContent());


        });
		
	});
</script>

