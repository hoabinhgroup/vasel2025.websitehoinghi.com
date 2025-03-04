@extends('base::cmspanel.layout.dashboard')

@section('title',' - Danh sách Categories')

@push('styles')
 <link rel="stylesheet" type="text/css" href="/css/select2.min.css">

     
@endpush

@section('sidebar')
	@parent
@stop

@section('content')
@php
$dropdown = array(
	array(
		'id' => 0,
		'text' => 'Chon Menu cha',
		),
	array(
		'id' => 1,
		'text' => 'Iphone',
		),
	array(
		'id' => 2,
		'text' => 'Android',
		),
	array(
		'id' => 3,
		'text' => 'Waifu',
		),	
	array(
		'id' => 4,
		'text' => 'Xiaomi',
		),
);
$dropdown = json_encode($dropdown);

@endphp;
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
	            
              <div class="card-body">            

	    
	 <div class="table-responsive">
		 
		<div class="table-toolbar"></div>
		 
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
	   louisData = $('#menu-table').louisTable({
		 	url: '{!! route('datatables.data') !!}',
		 	hideTools: false,
		 	create_button: [{url: '{!! route('menu.create') !!}' }],
		 	filterDropdown: [{name: "parent", class: "w200 select2 select2-size", options: {!! $select !!} }],
		 	columns: [
	        	{ data: 'index', name: 'index' , 'width' : "5%", visible: false },
				{ data: 'id', name: 'id' , 'width' : "5%" },
				{ data: 'name', name: 'name', 'width' : "55%" },
				{ data: 'parent', name: 'parent', 'width' : "20%" },
				{ data: 'action', name: 'action', orderable: false },
			],
		 	onAjaxSuccess: function(result){
			 	console.log(result);
		 	}
		});	
	//$('#customer-table').data('plugin_louisTable')._destroy();  
	//louisData._destroy();
	//louisData.load();
	});
 
});


	</script>
@endpush
