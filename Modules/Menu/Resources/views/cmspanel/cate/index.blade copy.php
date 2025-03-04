@extends('base::cmspanel.layout.dashboard')

@section('title',' - Danh sách Categories')

@push('styles')
     
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
                <h4 class="card-title">Danh sách danh mục</h4>
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
	           <select data-column="3" name="parent" id="parent">
		           <option value="0">Chon menu cha</option>
		           <option value="1">Iphone</option>
		           <option value="2">Android</option>
		           <option value="3">Waifu</option>
		           <option value="4">Xiaomi</option>
	           </select>   
              <div class="card-body">
<a href="{!! route('menu.create') !!}" class="btn btn-info" data-keyboard="false" title="Thêm"><i class="icon-plus font-weight-bold"></i> Thêm</a>    

	   
	    
	 <div class="table-responsive">
	     <div class="dataTables_wrapper dt-bootstrap4">
		     	 <table class="table table-bordered table-striped dataTable" id="menu-table">
        <thead>
            <tr>
	            <th>Index</th>
                <th>Id</th>
                <th>Tiêu đề</th>
                <th class="text-center">Danh mục cha</th>
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
	var filterParams = [];
	
	   
   

	 $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
	
	var table = $('#menu-table').DataTable({
		dom: 'lfrtBip',
		sorting: [[ 0, "asc" ]],
        processing: true,
        serverSide: true,
        "language": {
			processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> ',
			emptyTable:     "Không có dữ liệu",
			info: "Hiển thị _START_ đến _END_ / _TOTAL_ dòng",
			infoEmpty:      "Hiển thị 0 đến 0 / 0 dòng",
			infoFiltered:   "(đã lọc từ _MAX_ dòng)",
			lengthMenu:     "Hiển thị _MENU_",
			search:         "Tìm kiếm:",
			zeroRecords:    "Không có dữ liệu được tìm thấy",
			paginate: {
				"first":      "First",
				"last":       "Last",
				"next":       "Next",
				"previous":   "Previous"
			},
			
		},
        ajax: {
	        url: '{!! route('datatables.data') !!}',
	        data: function(data) { data = filterParams; }
        },
        columns: [
	        { data: 'index', name: 'index' , 'width' : "5%", visible: false },
            { data: 'id', name: 'id' , 'width' : "5%", visible: true },
            { data: 'name', name: 'name', 'width' : "50%" },
            { data: 'parent', name: 'parent', 'width' : "20%" },
            { data: 'action', name: 'action', orderable: false },
        ],
        initComplete: function(settings, json) {
	        
			console.log(json);
			}
    });
    
    
     $('body').on('click', '[data-action="delete-confirmation"]', function () {
 
        var post_id = $(this).attr("data-post-id");
        
        if(confirm("Bạn có chắc muốn xóa !")){
 
        $.ajax({
            type: "POST",
            url: '{!! route('menu.delete') !!}',
            data: {'id' : post_id},
            success: function (data) {
	            console.log('success',data);
            let oTable = $('#menu-table').dataTable(); 
           	    oTable.fnDraw(false);
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
        }
    });
    
    
     $("#parent").on('change', function(){
	    filterParams['parent'] = $(this).val();
	    let oTable = $('#menu-table').dataTable(); 
           	    oTable.fnDraw(false);
	   /* table.column($(this).data('column'))
	    	 .search($(this).val())
			 .draw();	
			 */
    });
 
    
});


	</script>
@endpush
