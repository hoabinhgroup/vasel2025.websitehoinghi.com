<a href="{{ route('menu.edit', [$id]) }}" class="text-primary" data-keyboard="false" title="Sửa"><i class="icon-pencil font-weight-bold"></i> Sửa</a> | 	
<a href="javascript:void(0)" title="Xóa" class="text-danger _delete" data-post-id="{{ $id }}" data-action-url="{{ route('menu.delete', [$id]) }}" data-action="delete-confirmation"><i class="icon-close font-weight-bold"></i> Xóa</a>
