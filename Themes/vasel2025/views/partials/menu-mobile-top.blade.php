@foreach($data['nodes'] as $node)
@php
$nofollow = '';
@endphp
<div class="menu-bar-lv-{{ $data['level'] }}">
	@if($node['parent_id'] == 0)
		
	  <a {{ $nofollow }} {{ ($node['target'] == '_blank')?' target="_blank"':'' }}  class="level-top" href="{{ ($node['target'] == '_directUrl')? $node['url'] : env('APP_URL') . '/' . $node['url'] .'.html' }}" title="{{ $node['title'] }}"><i class="fa fa-angle-right"></i> {!! $node['title'] !!} </a>
	 @else

		 @if($data['level'] > 1)
		<a class="a-lv-2" {{ $nofollow }} {{ ($node['target'] == '_blank')?' target="_blank"':'' }} href="{{ ($node['target'] == '_directUrl')? $node['url'] : env('APP_URL') . '/' . $node['url'] .'.html' }}"><i class="fa fa-angle-right"></i> {{ $node['title'] }}</a>
		@endif
	@endif

	  @if($node['has_child'])

			{!!  Menu::renderMenu([
					  'slug' => $data['slug'],
					  'options' => ['class' => 'menu-bar-lv-2', 'id' => 'item'. $node['id']],
					  'theme' => true,
					  'view' => 'menu-mobile-top',
					  'parent_id' => $node['id'],
					  'level' => $data['level'] + 1
						])  !!}

	  @endif
	  @if($node['parent_id'] == 0)
	  	<span class="span-lv-1 fa fa-angle-down"></span>
	  @endif
	 </div>
	@endforeach



