  @php

  $collection = $config['stats'];
  $total = $config['total'];
  //$mostVisistedPages = $config['mostVisistedPages'];
  $labels = $collection->map(function($label) {
	  return $label['axis'];
  });

  $visitors = $collection->map(function($visitor) {
		return $visitor['visitors'];
	});

 $pageviews = $collection->map(function($pageview) {
	 return $pageview['pageViews'];
 });



  @endphp
  <section id="chartjs-line-charts">

	<!-- Line Stacked Area Chart -->
	<div class="row">
	  <div class="col-12">
		<div class="card">
		  <div class="card-header">
			<h4 class="card-title">Thống kê truy cập </h4>
			<a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
			<div class="heading-elements">
			  <ul class="list-inline mb-0">
				<li><a data-action="collapse"><i class="ft-minus"></i></a></li>
				<li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
				<li><a data-action="expand"><i class="ft-maximize"></i></a></li>
				<li><a data-action="close"><i class="ft-x"></i></a></li>
			  </ul>
			</div>
		  </div>
		  <div class="card-content collapse show">
			<div class="card-body chartjs">
			<canvas id="line-stacked-analytics" height="500"></canvas>
		  </div>
		  </div>
		</div>
	  </div>
	</div>
  </section>

  <div class="row">
  <div class="col-xl-3 col-lg-6 col-12">
	<div class="card">
	  <div class="card-content">
		<div class="card-body">
		  <div class="media d-flex">
			<div class="align-self-center">
			  <i class="fa fa-eye primary font-large-2 float-left"></i>
			</div>
			<div class="media-body text-right">
			  <h3>{{ $total['ga:sessions'] }}</h3>
			  <span>Phiên</span>
			</div>
		  </div>
		</div>
	  </div>
	</div>
  </div>
  <div class="col-xl-3 col-lg-6 col-12">
	<div class="card">
	  <div class="card-content">
		<div class="card-body">
		  <div class="media d-flex">
			<div class="align-self-center">
			  <i class="fa fa-users warning font-large-2 float-left"></i>
			</div>
			<div class="media-body text-right">
			  <h3>{{ $total['ga:users'] }}</h3>
			  <span>Người truy cập</span>
			</div>
		  </div>
		</div>
	  </div>
	</div>
  </div>
  <div class="col-xl-3 col-lg-6 col-12">
	<div class="card">
	  <div class="card-content">
		<div class="card-body">
		  <div class="media d-flex">
			<div class="align-self-center">
			  <i class="icon icon-direction success font-large-2 float-left"></i>
			</div>
			<div class="media-body text-right">
			  <h3>{{ $total['ga:pageviews'] }}</h3>
			  <span>Lượt xem</span>
			</div>
		  </div>
		</div>
	  </div>
	</div>
  </div>
  <div class="col-xl-3 col-lg-6 col-12">
	<div class="card">
	  <div class="card-content">
		<div class="card-body">
		  <div class="media d-flex">
			<div class="align-self-center">
			  <i class="icon-graph danger font-large-2 float-left"></i>
			</div>
			<div class="media-body text-right">
			  <h3>{{ round($total['ga:bounceRate'], 2) }}%</h3>
			  <span>Tỷ lệ thoát</span>
			</div>
		  </div>
		</div>
	  </div>
	</div>
  </div>
</div>

<div class="row">
<div class="col-xl-3 col-lg-6 col-12">
  <div class="card">
	<div class="card-content">
	  <div class="card-body">
		<div class="media d-flex">
		  <div class="media-body text-left">
			<h3 class="danger">{{ round($total['ga:percentNewSessions'], 2) }}%</h3>
			<span>Tỷ lệ khách mới</span>
		  </div>
		  <div class="align-self-center">
			<i class="icon-user-follow danger font-large-2 float-right"></i>
		  </div>
		</div>
	  </div>
	</div>
  </div>
</div>
<div class="col-xl-3 col-lg-6 col-12">
  <div class="card">
	<div class="card-content">
	  <div class="card-body">
		<div class="media d-flex">
		  <div class="media-body text-left">
			<h3 class="success">{{ round($total['ga:pageviewsPerVisit'], 2) }}</h3>
			<span>Trang/ Phiên</span>
		  </div>
		  <div class="align-self-center">
			<i class="icon-graph success font-large-2 float-right"></i>
		  </div>
		</div>
	  </div>
	</div>
  </div>
</div>
<div class="col-xl-3 col-lg-6 col-12">
  <div class="card">
	<div class="card-content">
	  <div class="card-body">
		<div class="media d-flex">
		  <div class="media-body text-left">
			<h3 class="warning">{{ gmdate('H:i:s', $total['ga:avgSessionDuration']) }}</h3>
			<span>Trung bình</span>
		  </div>
		  <div class="align-self-center">
			<i class="icon-clock warning font-large-2 float-right"></i>
		  </div>
		</div>
	  </div>
	</div>
  </div>
</div>
<div class="col-xl-3 col-lg-6 col-12">
  <div class="card">
	<div class="card-content">
	  <div class="card-body">
		<div class="media d-flex">
		  <div class="media-body text-left">
			<h3 class="primary">{{ $total['ga:newUsers'] }}</h3>
			<span>Lượt khách mới</span>
		  </div>
		  <div class="align-self-center">
			<i class="icon-pie-chart primary font-large-2 float-right"></i>
		  </div>
		</div>
	  </div>
	</div>
  </div>
</div>
</div>

@php



@endphp

  <script>
  var dataStatsAnalytics = '{{ json_encode($labels->toArray()) }}';
  dataStatsAnalytics = JSON.parse(dataStatsAnalytics.replace(/&quot;/g,'"'));

  var visitors = '{{ json_encode($visitors->toArray()) }}';
  visitors = JSON.parse(visitors.replace(/&quot;/g,'"'));

  var pageviews = '{{ json_encode($pageviews->toArray()) }}';
  pageviews = JSON.parse(pageviews.replace(/&quot;/g,'"'));

  </script>

 @php
  Assets::add([
	  domain() . '/vendors/js/charts/chart.min.js',
	  domain() . '/vendors/js/charts/jquery.sparkline.min.js',
  ]);
  Assets::addJs(
	  domain() . '/vendor/core/modules/analytics/js/analytics.js?v=1.8.49'
  );
 @endphp


