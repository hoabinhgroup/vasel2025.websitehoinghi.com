<style>
.buttons-table{
	display: inline-block;
}

div.dataTables_wrapper{
	padding-top: 0px;
}
</style>

      <div class="table-responsive">

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
	//var louisData;
	$(document).ready(function(){
	 $('#{{ $table->getOptions()["id"] }}').louisTable({
		    dom: "{!! $dom !!}",
		 	url: '{{ $table->getAjaxUrl() }}',
		 	sorting: [[ {{ $table->getSortColumn() }}, "desc" ]],
		 	bulk_action: @json($actions),
		 	tabbar: '{{ $table->ishasTab() }}',
		 	buttons: @json($table->getBuilderParameters()),
		 	filterDropdown: @json($filterDropdown),
		 	filterDateRange: '{{ $table->isHasFilterDateRange() }}',
		 	searching: false,
			pagingType: "simple",
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
					"next":       "»",
					"previous":   "«"
				},

			},
			onInitComplete: {!! $table->htmlInitComplete() !!},
			onDrawCallback: {!! $table->htmlDrawCallback() !!}
		});

	});

});


	</script>

