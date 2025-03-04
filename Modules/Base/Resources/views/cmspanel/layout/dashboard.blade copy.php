<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">

<head>
  <!-- CSRF Token -->
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta name="description" content="">
  <meta name="keywords" content="">
  <meta name="author" content="Louis">
  <title>{{ page_title()->getTitle() }}</title>
  {{--
  <link rel="manifest" href="/favicon/manifest.json"> --}}
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="msapplication-TileImage" content="/favicon/ms-icon-144x144.png">
  <meta name="theme-color" content="#ffffff">
  <link
    href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i%7COpen+Sans:300,300i,400,400i,600,600i,700,700i"
    rel="stylesheet">
  <!-- BEGIN VENDOR CSS-->
  <link rel="stylesheet" type="text/css" href='/css/bootstrap.min.css'>
  <link rel="stylesheet" type="text/css" href='/fonts/feather/style.min.css'>
  <link rel="stylesheet" type="text/css" href='/fonts/flag-icon-css/css/flag-icon.min.css'>
  <link rel="stylesheet" type="text/css" href='/fonts/font-awesome/css/font-awesome.min.css'>
  <link rel="stylesheet" type="text/css" href='/vendors/css/extensions/pace.css'>
  <link rel="stylesheet" type="text/css" href='/vendors/css/charts/jquery-jvectormap-2.0.3.css'>

  <link rel="stylesheet" type="text/css" href='/vendors/css/charts/morris.css'>
  <link rel="stylesheet" type="text/css" href='/vendors/css/extensions/unslider.css'>

  <link rel="stylesheet" type="text/css" href='/css/app.css?v=1.1'>
  <link rel="stylesheet" type="text/css" href='/css/perfect-scrollbar.css'>
  <link rel="stylesheet" type="text/css" href='/css/core/colors/palette-gradient.min.css'>

  <!-- BEGIN Page Level CSS-->
  <link rel="stylesheet" type="text/css" href='/css/core/menu/menu-types/vertical-menu.css'>
  <link rel="stylesheet" type="text/css" href="/css/jquery.toast.min.css">
  <!--<link rel="stylesheet" href="/public/css/datatable.min.css">-->

  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.3.0/css/flag-icon.min.css">
  <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.7.5/css/bootstrap-select.min.css">
  <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

  <link rel="stylesheet" type="text/css" href='/css/style.css'>
  <link rel="stylesheet" type="text/css" href='/css/extra.css'>
  <link rel="stylesheet" type="text/css" href='/css/custom.css'>

  {!! Assets::css() !!}
  <link rel="stylesheet" type="text/css"
    href="https://cdn.jsdelivr.net/npm/pretty-checkbox@3.0/dist/pretty-checkbox.min.css">
  <script src="/vendors/js/vendors.min.js" type="text/javascript"></script>
  <script src="https://js.pusher.com/beams/1.0/push-notifications-cdn.js"></script>
  <script>
    const beamsClient = new PusherPushNotifications.Client({
      instanceId: '1ba87a73-ad9f-4b34-b0b6-307e537f358f',
    });

    beamsClient.start()
      .then(() => beamsClient.addDeviceInterest('hello'))
      .then(() => console.log('Successfully registered and subscribed!'))
      .catch(console.error);
  </script>
  @stack('header')
  @stack('styles')
  <!-- END Custom CSS-->
  <!-- BEGIN VENDOR JS-->

</head>

<style>
  .align-self-center {
    flex: 0 !important;
  }


  .modal-title {
    color: #000;
  }

  .dataTables_length {
    position: absolute;
    z-index: 100;
  }

  .dataTables_info {
    position: absolute;
    padding-top: 0px !important;
  }

  .dataTables_wrapper {
    padding-top: 10px;
  }

  div.dataTables_wrapper {
    float: left;
  }

  div.dataTables_wrapper div.dataTables_filter label {
    margin-top: 0px;
  }

  .dataTables_filter {
    position: relative;

  }

  .dataTables_paginate {
    position: relative;
    right: 5px;
  }

  .help-block {
    color: red;
    font-size: 0.8em;
    margin-top: 5px;
    display: block;
  }

  div.DTTT_container {
    position: relative;
    float: left;
  }

  div.dataTables_wrapper div.dataTables_filter {
    float: left;
  }

  .table-toolbar {
    height: 0px;
  }

  .date-range-element {
    position: relative;
  }

  .mr15 {
    margin-right: 15px;
  }

  .pull-left {
    float: left;
  }

  .dataTables_filter input[type="search"] {
    height: 36px;
    width: 200px !important;
    position: relative;
    top: 5px;
  }

  .badge-pending {
    background-color: #2DCEE3;
  }

  .badge-draft {
    background-color: #BABFC7;
  }

  .badge-published {
    background-color: #16D39A;
  }

  /* .dataTables_filter input[type="search"]:focus{
    width: 200px !important;
} */

  .dataTables_filter label::after {
    font-family: FontAwesome;
    content: "\F002";
    position: absolute;
    right: -4px;
    top: 6px;
    width: 40px;
    height: 30px;
    line-height: 30px;
    text-align: center;
    color: #495057;
    font-weight: 900;
  }

  .ml15 {
    margin-left: 15px;
  }

  #section_bulk_action {
    float: left;
  }

  #section_bulk_action input[type="submit"] {
    float: left;
  }

  #bulk_action {
    width: 200px;
    float: left;
    margin-right: 5px;
  }

  table tr th:first-child .pretty,
  table tr td:first-child .pretty {
    margin-right: 0px;
  }

  table tr th:first-child input {
    text-align: center;
  }

  table tr td:first-child,
  table th:first-child {
    padding: 10px;
    text-align: center;
  }

  table tr td,
  table th,
  table th input {
    vertical-align: middle !important;
  }

  #section_bulk_action {
    margin-right: 5px;
  }

  .tabbar {
    padding: 10px;
    margin-left: 5px;
  }

  .anchor_tab {
    color: #757373;
  }

  .anchor_tab.active {
    color: #008385 !important;
  }

  .mr5 {
    margin-right: 5px;
  }

  .w200 {
    width: 180px !important;
  }


  .extra_toolbar select {
    width: fit-content;
  }
</style>

<body class="vertical-layout vertical-menu 2-columns   menu-expanded fixed-navbar" data-open="click"
  data-menu="vertical-menu" data-col="2-columns">

  <div id="app">
    <!-- fixed-top-->
    <nav class="header-navbar navbar-expand-md navbar navbar-with-menu fixed-top navbar-semi-dark navbar-shadow">
      <div class="navbar-wrapper">
        <div class="navbar-header">
          <ul class="nav navbar-nav flex-row">
            <li class="nav-item mobile-menu d-md-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs"
                href="#"><i class="ft-menu font-large-1"></i></a></li>
            <li class="nav-item nav-logo">
              <a class="navbar-brand" href="/{{ BACKEND }}">
                <img width="150" class="brand-logo" alt="stack admin logo"
                  src="https://cdn.websitehoinghi.com/logo-cms-white-1-1.png">
                <!-- <h2 class="brand-text">{{ setting('admin_title') }}</h2> -->
              </a>
            </li>
            <li class="nav-item d-md-none">
              <a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i
                  class="fa fa-ellipsis-v"></i></a>
            </li>
          </ul>
        </div>
        <div class="navbar-container content">
          <div class="collapse navbar-collapse" id="navbar-mobile">
            <ul class="nav navbar-nav mr-auto float-left">
              <li class="nav-item d-none d-md-block"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i
                    class="ft-menu"></i></a></li>
              <li class="nav-item d-none d-md-block"><a target="_blank" class="nav-link nav-link-expand" href="/"><i
                    class="icon-globe"></i></a></li>
              <li class="nav-item nav-search"><a class="nav-link nav-link-search" href="#"><i
                    class="ficon ft-search"></i></a>
                <div class="search-input">
                  <input class="input" type="text" placeholder="Tìm kiếm...">
                </div>
              </li>
            </ul>
            <ul class="nav navbar-nav float-right">
              @if (Auth::check())
              {!! apply_filters(BASE_FILTER_TOP_HEADER_LAYOUT, null) !!}
              @endif
              @if(is_plugin_active('Languages'))
              @php
              $languages = \Modules\Languages\Entities\Languages::all()->toArray();

              @endphp

              <li class="dropdown dropdown-language nav-item"><a class="dropdown-toggle nav-link" id="dropdown-flag"
                  href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                    class="flag-icon flag-icon-{{ getDefaultLanguage(['lang_flag'])->lang_flag }}"></i><span
                    class="selected-language"></span></a>
                <div class="dropdown-menu" aria-labelledby="dropdown-flag">

                  @foreach($languages as $lang)

                  <a class="dropdown-item" href="{!! route('backend.change-language', [$lang['lang_locale']]) !!}"><i
                      class="flag-icon flag-icon-{{ $lang['lang_flag'] }}"></i> {{ $lang['lang_name'] }} </a>

                  @endforeach


                </div>
              </li>
              @endif


              {{--notification--}}

              @if(is_plugin_active('Notification'))

              <notification :userid="{{ auth()->id() }}" :unreads="{{ auth()->user()->unreadNotifications }}">
              </notification>

              @endif




              <li class="dropdown dropdown-user nav-item">
                <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                  <span class="avatar avatar-online">
                    <img style="height:30px;"
                      src="{{ Auth::user()->profile_image ? asset('uploads/avatar/'.auth()->id().'/'.Auth::user()->profile_image) : '' }}"
                      alt="avatar"><i></i></span>
                  <span class="user-name">{{ Auth::user()->name }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item"
                    href="{{ route('user.edit.own.profile') }}"><i class="ft-user"></i> Sửa thông tin</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="/cmspanel/auth/logout"><i class="ft-power"></i> Thoát</a>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </nav>
  </div>

  <!-- ////////////////////////////////////////////////////////////////////////////-->
  <div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="main-menu-content">
      @section('sidebar')
      <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
        <li class=" navigation-header">
          <span>General</span><i class=" ft-minus" data-toggle="tooltip" data-placement="right"
            data-original-title="General"></i>
        </li>
        @include('base::cmspanel.layout.partials.sidebar')

      </ul>
      </li>


      </ul>
      @show

    </div>
  </div>
  <div class="app-content content">
    <div class="content-wrapper">
      <div class="content-header row">
        <div class="content-header-left col-md-12 col-12 mb-2">
          <h3 class="content-header-title mb-0">{{ explode('|', page_title()->getTitle())[0] }}</h3>
          <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
              {!! Breadcrumbs::render('main', page_title()->getTitle(false)) !!}
            </div>
          </div>
        </div>
      </div>

      @yield('content')
    </div>

  </div>
  @include('menu::cmspanel.partials.mustache_template')
  @include('base::cmspanel.layout.modal')
  @stack('footer')
  <!-- ////////////////////////////////////////////////////////////////////////////-->
  <footer class="footer footer-static footer-light navbar-border">
    <p class="clearfix blue-grey lighten-2 text-sm-center mb-0 px-2">
      <span class="float-md-left d-block d-md-inline-block">Copyright &copy; 2018 <a class="text-bold-800 grey darken-2"
          href="#" target="_blank">Louis </a>, All rights reserved. </span>
      <span class="float-md-right d-block d-md-inline-block d-none d-lg-block"> Louis <i
          class="ft-heart pink"></i></span>
    </p>
  </footer>

  <script src="/js/general.js" type="text/javascript"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/moment.min.js"
    type="text/javascript"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.js"
    type="text/javascript"></script>
  <!--   <script src="/public/js/perfect-scrollbar.min.js"></script> -->

  <script src="/js/core/app-menu.js?v=1.1" type="text/javascript"></script>

  <script src="/js/core/app.js" type="text/javascript"></script>

  <script src="/js/scripts/customizer.js" type="text/javascript"></script>

  <!-- DataTables -->
  <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
  <!-- BEGIN VENDOR JS-->
  <!-- BEGIN PAGE VENDOR JS-->
  <script src="/js/jquery.validate.min.js"></script>
  <script src="/js/jquery.toast.min.js"></script>
  <script src="/js/app.custom.js" type="text/javascript"></script>
  <script src="/js/jquery.louisForm.js" type="text/javascript"></script>
  <script src="/js/jquery.louisTable.js?v=1.9.5" type="text/javascript"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.7.5/js/bootstrap-select.min.js"></script>
  @php
  $currentRouteName = Route::currentRouteName();
  $loadVueFiles = true;


  switch($currentRouteName){
  case 'membership.import':
  $appJs = 'app-customers-job-excel';
  break;
  case 'membership.index':
  $appJs = 'app-customers-assign-services';
  break;
  default:
  $appJs = 'app-customers-job-excel';
  $loadVueFiles = false;
  break;
  }

  if($loadVueFiles){
  Assets::addJs(domain() . '/js/' . $appJs. '.js?v='. time());
  }
  @endphp
  {!! Assets::js() !!}

  {{--
  <script src="/public/js/app-broadcast.js?v=1.7.8" type="text/javascript"></script> --}}
  @stack('scripts')

  <!-- END STACK JS-->
  <!-- BEGIN PAGE LEVEL JS-->
  <script>




  </script>
  <!-- END PAGE LEVEL JS-->

</body>

</html>