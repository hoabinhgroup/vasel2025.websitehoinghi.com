@extends('base::cmspanel.layout.dashboard')

@push('styles')
 <link rel="stylesheet" type="text/css" href="/css/select2.min.css">
@endpush

@section('content')
<style>
.btn-bulk-action{
    float: left;
    height: 40px;
    margin-right: 1rem!important;
}
.table-responsive{
    overflow-x: hidden;
}

.label.label-primary{
   background: cadetblue;
}
.filter-toolbar{
   display: flex !important;
}
.table th, .table td{
    padding: 0.75rem 1rem;
}
.btn-extra::after{
    right: 4px;
}
.dropdown-content{
    padding-left: 0px;
}
.dropdown-menu.arrow{
    margin-top: 8px;
}
.w220{
    width: 220px !important;
}
.w250{
    width: 250px !important;
}
.wrapper-action{
    position: absolute;
    z-index: 1000;
    display: inline-block;
}
.btn-light.dropdown-toggle:hover, .btn-light.dropdown-toggle:focus{
    background: #fff !important;
}
.btn-light{
    background: #fff;
}
.dropdown-menu{
    height: fit-content;
}
.dropdown-menu li:nth-child(2){
    border-top: 1px solid #dfdfdf;
    padding-top: 5px;
    margin-top: 10px;
    padding-left: 20px;
}
.buttons-table{
	display: inline-block;
}
.select2-search__field[type="search"]{
	outline-color: #00B5B8;
	outline-offset: 0px;
}
.select2-selection--single:focus{
	outline: none;
}
.sr-only{
	background: transparent;
}
.date-range-element{
	width: 300px;
}
.date-range-element .fa-calendar{
   position: absolute;
    top: 15px;
    right: 30px;
}
div.dataTables_wrapper{
	padding-top: 0px;
}
.dataTables_filter input[type="search"]{
	top: 0px;
	height: 40px;
}
.dataTables_filter{
   order: 999;
}
div.dataTables_filter input{

}
div.dataTables_wrapper div.dataTables_processing{

}
.card_extra_toolbar{
    display: none;
}
.extra_toolbar {
    position: absolute;
    width: 100%;
    display: flex;
    justify-content: space-around;
}
.btn-show-extra-toolbar{
	float: right;
}
.extra_toolbar {
	margin-right: 5px !important;

}

.extra_toolbar .p-0{
	float: right;
}
.extra_toolbar .glyphicon-calendar{
	position: absolute;
    right: 5px;
    top: 12px;
}
.daterangepicker{
	top: 205px !important;
}
.daterangepicker .calendar-table td, .daterangepicker .calendar-table th{
	line-height: 16px;
}
.daterangepicker td.active, .daterangepicker td.active:hover{
	background: #2DCEE3;
}
.daterangepicker .ranges li.active{
	background: #2DCEE3;
}
</style>

{{-- <select class="select2 form-control" multiple>
    <option value="0">value 1</option>
    <option value="1">value 2</option>
    <option value="2">value 3</option>
    <option value="3">value 4</option>
</select> --}}

      <div class="content-body">
      <div class="card card_extra_toolbar">
        <div class="card-content collapse show">
            <div class="card-body">
                <div class='extra_toolbar row'></div>
            </div>
        </div>

      </div>
      <div class="card">

           <div class="card-content collapse show">

         <div class="card-body">


	 <div class="table-responsive">

		  <div class="dataTables_wrapper dt-bootstrap4">
           
          <div class="wrapper-action">
           @if ($actions)
               <div class="btn-group btn-bulk-action">
                   <a class="btn btn-light dropdown-toggle" href="#" data-toggle="dropdown">{{ trans('base::tables.bulk_actions') }}
                   </a>
                   <ul class="dropdown-menu arrow">
                       @foreach ($actions as $action)
                           <li>
                               {!! $action !!}
                           </li>
                       @endforeach
                   </ul>
               </div>
           @endif

       </div>
        
		  @php

		//dd($table->getColumns());
		//dd($actions);
		//dd($table->ishasTab());
		 @endphp


		  <table class="{{ $table->getOptions()['class'] }}" id="{{ $table->getOptions()['id'] }}">
        <thead>
            <tr>
              @php
              $columns = [];
              @endphp
                @foreach($table->getColumns() as $field => $column)
                	@php
	                	$columns[] = array_merge(['data' => $field], \Arr::except($column,['title']));
                	@endphp
                	<th>
                	{!! $column['title'] !!}

                	 </th>
                @endforeach
            </tr>
        </thead>
    </table>
		  </div>
     </div>



              </div><!--.card-body-->
              </div><!-- .card-content -->
            </div><!-- .card-->
      </div>

@stop

@push('scripts')
<script src="/js/select2.min.js"></script>

 <script type="text/javascript">
$(function() {
	var louisData;
	$(document).ready(function(){
	   louisData = $('#{{ $table->getOptions()["id"] }}').louisTable({
		    dom: "{!! $dom !!}",
		 	url: '{{ $table->getAjaxUrl() }}',
		 	sorting: [[ {{ $table->getSortColumn() }}, "desc" ]],
		 	//bulk_action: @json($actions),
		 	tabbar: '{{ $table->ishasTab() }}',
		 	buttons: @json($table->getBuilderParameters()),
		 	filterDropdown: @json($filterDropdown),
		 	filterDateRange: '{{ $table->isHasFilterDateRange() }}',
		 	columns: @json($columns),
		 	language: {
				processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>',
				emptyTable:     "{{ __('base::tables.no_data') }}",
				info: "{{ __('base::tables.table-info') }}",
				infoEmpty:      "{{ __('base::tables.info-empty') }}",
				infoFiltered:   "{{ __('base::tables.info-filtered') }}",
				lengthMenu:     "{{ __('base::tables.length-menu') }}",
				search:         "{{ __('base::tables.search') }}",
				zeroRecords:    "{{ __('base::tables.zeroRecords') }}",
				paginate: {
					"first":      "{{ __('base::tables.first') }}",
					"last":       "{{ __('base::tables.last') }}",
					"next":       "{!! __('base::tables.next') !!}",
					"previous":   "{!! __('base::tables.previous') !!}"
				},

			},
			onInitComplete: {!! $table->htmlInitComplete() !!},
			onDrawCallback: {!! $table->htmlDrawCallback() !!},
			footerCallback: {!! $table->htmlFooterCallback() !!}
		});

	});

});


	</script>

@endpush


 @push('footer')


{{-- <script src="/js/table.js"></script> --}}

<div class="modal fade modal-bulk-change-items" id="modal-bulk-change-items" role="dialog" style="overflow:hidden;">
<div class="modal-dialog modal-sm">
<div class="modal-content">
<div class="modal-header bg-info">
<h4 class="modal-title"><i class="til_img"></i><strong>Bulk changes</strong></h4>
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
<span aria-hidden="true">×</span>
</button>
</div>
<div class="modal-body with-padding">
<div><div class="modal-bulk-change-content"></div></div>
</div>
<div class="modal-footer">
<button class="float-left btn btn-warning" data-dismiss="modal">Cancel</button>
<button class="float-right btn btn-info confirm-bulk-change-button" data-load-url="{{ route('tables.bulk-change.data') }}">Submit</button>
</div>
</div>
</div>
</div>

<div class="modal fade delete-many-modal" tabindex="-1" role="dialog">
<div class="modal-dialog modal-sm">
<div class="modal-content">
<div class="modal-header bg-danger">
<h4 class="modal-title"><i class="til_img"></i><strong>Confirm delete</strong></h4>
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
<span aria-hidden="true">×</span>
</button>
</div>
<div class="modal-body with-padding">
<div>Bạn muốn xóa những bản ghi này?</div>
</div>
<div class="modal-footer">
<button class="float-left btn btn-warning" data-dismiss="modal">Cancel</button>
<button class="float-right btn btn-danger delete-many-entry-button">Delete</button>
</div>
</div>
</div>
</div>

<script>


$(document).ready(function(){

   $('body').on('shown.bs.modal', '.modal', function(e) {
       //console.log('modal',$(this).find('.select2'));
       setTimeout(function(){  $('.select2').select2(); }, 1500);

         // $('.select2').select2({
         //     dropdownParent: $('#' + $(this).attr("id"))
         // });
       });

    $(function() {
        $("body").delegate(".date", "focusin", function(){

            $(this).datetimepicker({
                 // minDate: new Date(),
                  format: 'DD/MM/YYYY HH:mm:ss',
                  ignoreReadonly: true
              });
        });
    });

});
</script>

	@if(Session::has('success_msg'))
		<script> $(function() { $(document).ready(function(){
			appAlert.success("{{ Session::get('success_msg') }}", {container: 'body', duration: 3000});
		}); }); </script>
	@endif

	@if(Session::has('error_msg'))
		<script> $(function() { $(document).ready(function(){
			appAlert.error("{{ Session::get('error_msg') }}", {container: 'body', duration: 5000});
		}); }); </script>
	@endif

@endpush



