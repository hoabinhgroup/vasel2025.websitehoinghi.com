@foreach ($bulk_changes as $key => $bulk_change)
       <button class="dropdown-item" type="button"><a href="#" data-key="{{ $key }}" data-class-item="{{ $class }}" data-save-url="{{ $url }}"
           class="bulk-change-item">{{ $bulk_change['title'] }}</a></button>
    @endforeach




