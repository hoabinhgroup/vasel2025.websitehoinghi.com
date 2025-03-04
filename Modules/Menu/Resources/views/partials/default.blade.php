<ul class="{{ $data['options']['class'] }}" id="{{ $data['options']['id']?? '' }}">
	@foreach($data['nodes'] as $node)

		@if($node['parent_id'] == 0)
		
		  <li class="{{ $node['has_child']?' has-sub-menu ':'' }} {{ $node['css_class'] }} nav-item"><a {{ ($node['target'] == '_blank')?' target="_blank"':'' }}  class="nav-link" href="{{ ($node['target'] == '_directUrl')? $node['url'] : '/' . $node['url'] .'.html' }}" title="{{ $node['title'] }}">{{ $node['title'] }} @if($node['has_child']) <span class="caret"></span> @endif</a>
		 @else

		 	@if($data['level'] > 1)
		<li class="{{ $node['css_class'] }} list-group-item"> 
            <a {{ ($node['target'] == '_blank')?' target="_blank"':'' }} href="{{ ($node['target'] == '_directUrl')? $node['url'] : '/' . $node['url'] .'.html' }}">{{ $node['title'] }}</a>
			@endif	 	
		@endif	
		 				
		  @if($node['has_child'])
			    {!!  Menu::renderMenu([
                          'slug' => $data['slug'],
                          'options' => ['class' => 'sub-menu list-group'],
                          'theme' => true,
                          'parent_id' => $node['id'],
                          'level' => $data['level'] + 1
                            ])  !!}
                            			           
		  @endif
	 
            </li>        
		@endforeach
</ul>  
