@php
\Assets::addJs(domain() . "/assets/js/sortable/sortable.min.js");
// echo '<pre>';
// print_r($table->getBuilderParameters());
// echo '</pre>'; die();
@endphp
<style>
table{
    cursor: move;
}
</style>
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


@php


@endphp


 <script type="text/javascript">
$(function() {
    var louisData;
    $(document).ready(function(){
      louisData =  $('#{{ $table->getOptions()["id"] }}').louisTable({
            dom: "{!! $dom !!}",
             url: '{{ $table->getAjaxUrl() }}',
             sorting: [[ {{ $table->getSortColumn() }}, "asc" ]],
             bulk_action: @json($actions),
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

            },
            onInitComplete: {!! $table->htmlInitComplete() !!},
            onDrawCallback: {!! $table->htmlDrawCallback() !!}
        });

    });


});




    </script>

