<a data-act="ajax-modal" data-title="Sửa slide image"
      data-action-url="{{ route('api.slide.edit.modal', $item->id) }}"
      href="javascript:;" class="btn btn-info"><i class="fa fa-edit"></i></a>
<a href="javascript:void(0)" title="Xóa" class="btn btn-info  _delete" data-post-id="{{ $item->id }}" data-action-url="{{ route('slider-item.delete', $item->id) }}" data-action="delete-confirmation">
<i class="fa fa-trash"></i>
</a>
