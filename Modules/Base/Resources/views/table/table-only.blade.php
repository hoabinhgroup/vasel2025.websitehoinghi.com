<style>
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
	float: left;
	width: 300px;
}
div.dataTables_wrapper{
	padding-top: 0px;
}
.dataTables_filter input[type="search"]{
	top: 0px;
	height: 40px;
}
div.dataTables_filter input{
	margin-left: 1em !important;
}
div.dataTables_wrapper div.dataTables_processing{

}
.btn-show-extra-toolbar{
	float: right;
}
.extra_toolbar {
	margin-right: 5px !important;
	height: 50px;
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
	/*top: 205px !important;*/
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
@php
//dd($table);
@endphp
      <div class="table-responsive">

		<div class="table-toolbar"></div>
		  <div class="dataTables_wrapper dt-bootstrap4">

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


 <script type="text/javascript">
$(function() {
	var louisData;
	$(document).ready(function(){
	  louisData =  $('#{{ $table->getOptions()["id"] }}').louisTable({
		    dom: "{!! $dom !!}",
		 	url: '{{ $table->getAjaxUrl() }}',
		 	sorting: [[ {{ $table->getSortColumn() }}, "desc" ]],
		 	bulk_action: @json($actions),
		 	tabbar: '{{ $table->ishasTab() }}',
			data: @if(!empty($table->getOptions()['data'])) @json($table->getOptions()['data']) @else {} @endif,
		 	buttons: @json($table->getBuilderParameters()),
		 	filterDropdown: @json($filterDropdown),
		 	filterDateRange: '{{ $table->isHasFilterDateRange() }}',
		 	columns: @json($columns),
			rowId: '{{ $table->setRowIdByField() }}',
		 	language: {
				processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>',
				emptyTable:     "{{ __('base::tables.no_data') }}",
				info:           "{{ __('base::tables.table-info') }}",
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
			onDrawCallback: {!! $table->htmlDrawCallback() !!}
		});

	});

	// $("body").on("submit", "form", (e) => {
	//
	// 	console.log('louisData', louisData);
	// 		//louisData._load();
	// 		event.preventDefault();
	// 		  //that._onSubmit(e.currentTarget);
	// 		});

});




	</script>
