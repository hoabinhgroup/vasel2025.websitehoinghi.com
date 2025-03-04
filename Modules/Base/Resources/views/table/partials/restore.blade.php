<div class="table-actions">
        @if (Auth::user()->can($restore))
            <a href="{{ route($restore, [$item->id]) }}" class="text-primary" data-keyboard="false" title="{{ __('base::tables.restore') }}"><i class="fa fa-undo font-weight-bold"></i> {{ __('base::tables.restore') }}</a> 
        @endif
</div>
