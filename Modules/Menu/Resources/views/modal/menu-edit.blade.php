<div class="modal-body">
 	<form id="menuForm" action="{!! route('menu.update', [$id]) !!}" name="userForm" class="form-horizontal" method="POST">
          
            <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Tiêu đề</label>
                <div class="col-sm-12">
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="{{ $name }}" maxlength="50" required="">
                </div>
            </div>
 
            <div class="col-sm-offset-2 col-sm-10">
             <button type="submit" class="btn btn-primary" id="btn-save" value="create">Lưu
             </button>
            </div>
    </form>
</div>

    <script>
$(function() {    
    $("#menuForm").appForm({			
            	onAjaxSuccess: function(result){
	            	console.log('onAjaxSuccess',result);
	            if(result.success){	
		            let oTable = $('#menu-table').dataTable();
		            oTable.fnDraw(false);
	            	appAlert.success('ok', {container: 'body', duration: 3000});
	            	}
            	},
				onError: function(response) {
					console.log(response);
				},				
			});
    
});


	</script>
