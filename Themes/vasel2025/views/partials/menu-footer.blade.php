@foreach($data['nodes'] as $node)
@php
$nofollow = '';
@endphp
<div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
	@if($node['parent_id'] == 0)

		<aside  class="widget widget_text">
            <h3 class="widget-title"><a  class="level-top" href="{{ ($node['target'] == '_directUrl')? $node['url'] : env('APP_URL') . '/' . $node['url'] .'.html' }}" title="{{ $node['title'] }}">{!! $node['title'] !!}</a> </h3>
        </aside>
	 @else

		 @if($data['level'] > 1)
	<li class="{{ $node['css_class'] }} level1">
		<a {{ $nofollow }} {{ ($node['target'] == '_blank')?' target="_blank"':'' }}  href="{{ ($node['target'] == '_directUrl')? $node['url'] : env('APP_URL') . '/' . $node['url'] .'.html' }}">{{ $node['title'] }}</a>
		@endif
	@endif

	  @if($node['has_child'])

			{!!  Menu::renderMenu([
					  'slug' => $data['slug'],
					  'options' => ['class' => 'sub-menu', 'id' => 'text-3'],
					  'theme' => true,
					  'view' => 'menu-top',
					  'parent_id' => $node['id'],
					  'level' => $data['level'] + 1
						])  !!}

	  @endif

		</li>
		</div>
	@endforeach



