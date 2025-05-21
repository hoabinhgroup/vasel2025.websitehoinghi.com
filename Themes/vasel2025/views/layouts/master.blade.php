<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--[if IE 7]><html xmlns="http://www.w3.org/1999/xhtml" lang="eng" xml:lang="eng" class="ie7"><![endif]-->
<!--[if IE 8]><html xmlns="http://www.w3.org/1999/xhtml" lang="eng" xml:lang="eng" class="ie8"><![endif]-->
<!--[if IE 9]><html xmlns="http://www.w3.org/1999/xhtml" lang="eng" xml:lang="eng" class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html xmlns="http://www.w3.org/1999/xhtml" lang="eng" xml:lang="eng">
<!--<![endif]-->

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	{!! SeoHelper::render() !!}
	<meta http-equiv="X-UA-Compatible" content="IE=Edge,Chrome=1" />
	<meta name="viewport"
		content="width=device-width, initial-scale=1.0, maximum-scale=2.0, minimum-scale=1.0, user-scalable=no, target-densityDpi=medium-dpi">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
		integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
	<link type="text/css" rel="stylesheet" href="{{ themes('css/jquery-ui.css') }}" />

	{!! Assets::css() !!}

	<script type="text/javascript" src="{{ themes('script/jquery.js') }}"></script>

	<style>
		#banner {
			margin-bottom: 20px;
		}
	</style>
</head>

<body>
	<script>

	</script>

	<div class="wrapper">
		<div class="container">
			<div id="banner">
				<img width="100%" src="https://cdn.websitehoinghi.com/vasel2025/8c72c937d6f663a83ae7.jpg">
			</div>
		</div>
		@yield('content')

	</div>
	<!-- //wrapper -->

	<!-- <div class="layerPopup program_session_Area" id="layerPopup_glance" style="display:none;"></div> -->


	{!! Assets::js() !!}
</body>

</html>