@extends('theme::layouts.master')
@section('content')
<style>
    .fancybox__content {
        padding: 0px !important;
    }

    .wrapper-table {
        overflow: scroll;
        width: 100%;
    }

    figure figcaption {
        text-align: center;
        font-style: italic;
    }

    .news-detail h3 {
        font-size: 24px;
    }

    .news-detail ul {
        padding-left: 15px;
    }

    .news-detail ul li {
        list-style-type: disc;
    }
</style>


<div id="container" class="">
    <div class="contents" id="">
        <div class="sub-conbox inner-layer">
            <div class="sub-tit-wrap">
                <h3 class="sub-tit">{{ $page->name }}</h3>
            </div>
            {!! $page->content !!}
        </div>
    </div>
</div>
@endsection