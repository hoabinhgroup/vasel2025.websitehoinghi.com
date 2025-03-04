@extends('base::cmspanel.layout.dashboard')

@section('title',' - Danh sách Themes')

@push('styles')
     <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pretty-checkbox@3.0/dist/pretty-checkbox.min.css">
@endpush

@section('sidebar')
	@parent
@stop


@section('content')

<div class="content-wrapper">
      <div class="content-header row">
	    
      </div>
      <div class="content-body"> 
	      <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Quản lý Themes</h4>
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
	            
              <div class="card-body">
			  
		<div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                
                <div class="panel-body">
                    <div class="row pad">
                        @foreach(ThemeManager::getThemes() as $key =>  $theme)
                            <div class="col-sm-6 col-md-4 col-lg-3">
                                <div class="thumbnail">
                                    <div class="img-thumbnail-wrap" style="background-image: url('')"></div>
                                    <div class="caption">
                                        <div class="row">
                                            <div class="col-md-12" style="word-break: break-all">
                                                <h4>{{ ucfirst($theme['name']) }}</h4>
                                                <p>Tác giả: {{ $theme['author'] }}</p>
                                                <p>Phiên bản: {{ $theme['version'] }}</p>
                                                <p>Mô tả: {{ $theme['description'] }}</p>
                                            </div>
                                            <div class="clearfix"></div>
                                           
                                            <div>
                                                @if (setting('theme') == $theme['name'])
                                                    <a href="#" class="btn btn-danger" disabled="disabled"><i class="fa fa-check"></i> Đã kích hoạt</a>
                                                @else
                                                    <a href="{{ route('theme.active', [$key]) }}" class="btn btn-primary">Kích hoạt</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
	 
              </div><!--.card-body-->
              </div><!-- .card-content -->
            </div><!-- .card-->
          </div>
	      </div>
      </div>
</div>
@stop

@push('scripts')
    
@endpush
