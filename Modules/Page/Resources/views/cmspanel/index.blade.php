@extends('base::cmspanel.layout.dashboard')

@section('title',' - Danh sách Page')

@push('styles')
     <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pretty-checkbox@3.0/dist/pretty-checkbox.min.css">
      <link rel="stylesheet" type="text/css" href="/css/select2.min.css">
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
                <h4 class="card-title">Danh sách Trang</h4>
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
	   
	    
	 <div class="table-responsive">
 
		
		 
	     <div class="dataTables_wrapper dt-bootstrap4">
		     	 <table class="table table-bordered table-striped dataTable" id="page-table">
        <thead>
            <tr>
           	    <th>
<div class="pretty p-icon p-round">
        <input type="checkbox" class="ace" id="ck_All"  />
        <div class="state">
            <i class="icon fa fa-check"></i>
            <label></label>
        </div>
    </div>
					
					</th>
                <th>Id</th>
                <th>Tiêu đề</th>
                <th class="text-center">Đường dẫn</th>
                <th class="text-center">Trạng thái</th>
                <th class="text-center">Ngày thêm</th>
                <th class="text-center">Ngày sửa</th>
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
<script src="/js/select2.min.js"></script>
     <script>
	     
$(function() {
	
	 $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });


	var louisData;
	$(document).ready(function(){
	   louisData = $('#page-table').louisTable({
		 	url: '{!! route('datatables.data.page') !!}',
		 	bulk_action: true,
		 	tabbar: true,
		 	create_button: [{ url: '{!! route('backend.page.create') !!}' }],
		 	columns: [
				{ data: 'check', name: 'check' , orderable: false },
				{ data: 'id', name: 'id' , 'width' : "5%" },
				{ data: 'name', name: 'name', 'width' : "35%", orderable: false },
				{ data: 'slug', name: 'slug', 'width' : "20%", orderable: false  },
				{ data: 'status', name: 'status', "className": "text-center", 'width' : "5%", orderable: false  },
				{ data: 'created_at', name: 'created_at', "className": "text-center", 'width' : "5%", orderable: false  },
				{ data: 'updated_at', name: 'updated_at', "className": "text-center", 'width' : "5%", orderable: false  },
				{ data: 'action', name: 'action', orderable: false },
			],
		 	onAjaxSuccess: function(result){
			 	console.log('onAjaxSuccess',result.json);
		 	}
		});	
	});
	
	       
 
});



	</script>
@endpush
