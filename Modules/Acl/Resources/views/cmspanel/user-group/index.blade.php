@extends('base::cmspanel.layout.dashboard')

@section('title',' - Danh sách Nhóm')

@push('styles')
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
                <h4 class="card-title">Danh sách Nhóm</h4>
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
<a href="{!! route('backend.user-group.create') !!}" class="btn btn-info" data-keyboard="false" title="Thêm"><i class="icon-plus font-weight-bold"></i> Thêm</a>    
	   
	    
	 <div class="table-responsive">
		 
		<div class="table-toolbar"></div>
		 
	     <div class="dataTables_wrapper dt-bootstrap4">
		     	 <table class="table table-bordered table-striped dataTable" id="user-group-table">
        <thead>
            <tr>
                <th>Id</th>
                <th>Tên nhóm</th>
                <th>Thao tác</th>
            </tr>
        </thead>
    </table>
			 	 
		 </div>	 
     </div>
	
	 
              </div><!--.card-body-->
              </div><!-- .card-content -->
            </div><!-- .card-->
          </div>
	      </div>
      </div>
</div>
@stop

@push('scripts')
     <script>
$(function() {
	
	 $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });


	var louisData;
	$(document).ready(function(){
	   louisData = $('#user-group-table').louisTable({
		 	url: '{!! route('datatables.data.user-group') !!}',
		 	hideTools: false,
		 	columns: [
				{ data: 'id', name: 'id' , 'width' : "5%", visible: true },
				{ data: 'name', name: 'name', 'width' : "75%" },
				{ data: 'action', name: 'action', orderable: false },
			],
		 	onAjaxSuccess: function(result){
			 	console.log(result);
		 	}
		});	
	});
 
});


	</script>
@endpush
