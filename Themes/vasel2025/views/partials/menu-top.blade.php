<ul class="{{ $data['options']['class'] }}" id="{{ $data['options']['id'] ?? '' }}">
	@if($data['level'] <= 1)
		<li class="active"><a href="/"><i class="fa fa-home font-20"></i></a></li>
	@endif
	@foreach($data['nodes'] as $node)
		@php
			$nofollow = '';
		@endphp

		@if($node['parent_id'] == 0)
			@if(!$node['has_child'])
				<li class="{{ $node['has_child'] ? ' menu-item-has-children ' : '' }} {{ $node['css_class'] }}"><a {{ $nofollow }}
						{{ ($node['target'] == '_blank') ? ' target="_blank"' : '' }} class="level-top"
						href="{{ (($node['target'] == '_directUrl') || ($node['target'] == '_blank')) ? $node['url'] : env('APP_URL') . '/' . $node['url'] . '.html' }}"
						title="{{ $node['title'] }}"><span>{!! $node['title'] !!}</span> </a>
			@else

				<li class="{{ $node['has_child'] ? ' menu-item-has-children ' : '' }} {{ $node['css_class'] }}"><a {{ $nofollow }}
						{{ ($node['target'] == '_blank') ? ' target="_blank"' : '' }} class="level-top"
						href="{{ ($node['url'] != 'program' && $node['url'] != 'sponsorship') ? 'javascript:void(0)' : $node['url'] . '.html' }}"
						title="{{ $node['title'] }}"><span>{!! $node['title'] !!}</span> </a>
			@endif
		@else

				@if($data['level'] > 1)
					<li class="{{ $node['css_class'] }} list-type list-type-bar wh">
						<a {{ $nofollow }} {{ ($node['target'] == '_blank') ? ' target="_blank"' : '' }}
							href="{{ (($node['target'] == '_directUrl') || ($node['target'] == '_blank')) ? $node['url'] : env('APP_URL') . '/' . $node['url'] . '.html' }}">{{ strtolower($node['title']) }}</a>
				@endif
		@endif

			@if($node['has_child'])

				{!!  Menu::renderMenu([
					'slug' => $data['slug'],
					'options' => ['class' => 'sub-menu', 'id' => 'item' . $node['id']],
					'theme' => true,
					'view' => 'menu-top',
					'parent_id' => $node['id'],
					'level' => $data['level'] + 1
				])  !!}

			@endif

		</li>
	@endforeach


</ul>