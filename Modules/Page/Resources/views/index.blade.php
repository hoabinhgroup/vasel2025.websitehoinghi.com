@extends('theme::layouts.master')

@section('title',' Vsem 2019')

@section('content')
	<style>
	body .main-content .notice-important-dates-newsletter .module .module-content ul.list-group li{
		padding-bottom: 0px;
	}
	.module-content{
		padding-bottom: 10px;
	}
</style>
	
<div class="main-slider">
            <div class="col-md-12">
                <div id="carouselExampleFade" class="carousel slide carousel-fade" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="{{ themes('img/slides/slide1.jpg') }}" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                            <img src="{{ themes('img/slides/slide2.jpg') }}" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                            <img src="{{ themes('img/slides/slide3.jpg') }}" class="d-block w-100" alt="...">
                        </div>
						<div class="carousel-item">
                            <img src="{{ themes('img/slides/slide4.jpg') }}" class="d-block w-100" alt="...">
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleFade" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleFade" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="notice-important-dates-newsletter">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-lg-3 col-md-12">
	              
                    </div>
                    
                </div>
            </div>
        </div>

@endsection
