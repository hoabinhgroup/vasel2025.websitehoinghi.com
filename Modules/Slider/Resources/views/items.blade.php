<div class="card">
 <div class="card-body">
<div class="float-left">
<a data-act="ajax-modal" data-title="Thêm slide image"
   data-action-url="{{ route('api.slide.item.modal') }}"
   data-post-id="{{ request()
   ->route()
   ->parameter("slider") }}"
   href="javascript:;" class="btn btn-info"><i class="fa fa-plus-circle"></i> Thêm mới</a>
<button class="btn-success btn btn-save-sort-order" style="display: none;"><i
            class="fa fa-save"></i> {{ __('Save sorting') }}</button>
</div>

<br>

@include('base::table.table-simple')
</div>
</div>
