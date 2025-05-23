<ul class="breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">
    @foreach ($crumbs as $i => $crumb)
    @php

     @endphp
    
        @if ($i != (count($crumbs) - 1))
        <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
            <meta itemprop="position" content="{{ $i + 1}}" />
            <a href="{{ $crumb['url'] }}" itemprop="item" title="{{ $crumb['label'] }}">
                {{ $crumb['label'] }}
                <meta itemprop="name" content="{{ $crumb['label'] }}" />
            </a>
        </li>
        @else
        <li class="active"><a href="{{ $crumb['url'] }}">{{ $crumb['label'] }}</a></li>
        @endif
    @endforeach
</ul>
