<div class="table-actions">
    {!! $extra !!}
    @if (!empty($edit))
        @if (Auth::user()->can($edit))
            <a href="{{ route($edit, [$item->id]) }}" class="text-primary" data-keyboard="false" title="{{ __('base::tables.edit') }}"><i class="icon-pencil font-weight-bold"></i> {{ __('base::tables.edit') }}</a> | 
        @endif
    @endif

    @if (!empty($delete))
        @if (Auth::user()->can($delete))
            <a href="javascript:void(0)" title="Xóa" class="text-danger _delete" data-post-id="{{ $item->id }}" data-action-url="{{ route($delete, [$item->id]) }}" data-action="delete-confirmation" >
                <i class="icon-close font-weight-bold"></i> {{ __('base::tables.delete_entry') }}
            </a>
       @endif
    @endif
</div>
