@extends('cmspanel/layout/dashboard')

@section('title',' - Thêm Menu')

@push('styles')
     <link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/forms/toggle/switchery.min.css">
     <link rel="stylesheet" type="text/css" href="/app-assets/css/plugins/forms/switch.css">
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
                <h4 class="card-title">Danh sách bài viết</h4>
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
	      <div class="container">
	 @if ($errors->any())

                    @foreach($errors->all() as $error)
                    <div class="alert alert-danger border-0 mb-2" role="alert">
                    {!! $error !!}
                    </div>

                    @endforeach

                  @endif
     <form class="form-horizontal" action="{!! route("cmspanel.cate.postAdd") !!}" method="post">
	{{ csrf_field() }}
	<div class="row">
	<div class="col-md-8">
		<ul class="nav nav-tabs nav-topline">
                      <li class="nav-item">
                        <a class="nav-link active" id="base-tab21" data-toggle="tab" aria-controls="tab21"
                        href="#tab21" aria-expanded="true">Mặc định</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="base-tab22" data-toggle="tab" aria-controls="tab22" href="#tab22"
                        aria-expanded="false">Tiếng Việt</a>
                      </li>

                    </ul>
                    <div class="tab-content px-1 pt-1 border-grey border-lighten-2 border-0-top">
                      <div role="tabpanel" class="tab-pane active" id="tab21" aria-expanded="true" aria-labelledby="base-tab21">

                   <div class="form-group">
			<label for="">Tiêu đề</label>
			<input type="" class="form-control" id="" name="name" placeholder="" value="">
		</div>
		<div class="form-group">
			<label for="">Đường dẫn</label>
			<input type="" class="form-control" id="" name="link" placeholder="" value="">
		</div>
		<div class="form-group">
			<label for="">Nội dung</label>
			<textarea class="form-control" id="description" name="description" rows="20"></textarea>
		</div>
		<?php echo ckeditor("description", 350, "100%"); ?>
	</div>


					   <div role="tabpanel" class="tab-pane" id="tab22" aria-expanded="true" aria-labelledby="base-tab22">
						   <div class="form-group mt-1">
                      <input name="status_vi" type="checkbox" id="switcherySize1" class="switchery" value="1"  />
                      <label for="switcherySize1" class="font-medium-2 ml-1">Bật ngôn ngữ</label>

                    </div>
                        <div class="form-group">
			<label for="">Tiêu đề</label>
			<input type="" class="form-control" id="" name="name_vi" placeholder="" value="">
		</div>
		<div class="form-group">
			<label for="">Đường dẫn</label>
			<input type="" class="form-control" id="" name="link_vi" placeholder="" value="">
		</div>
		<div class="form-group">
			<label for="">Nội dung</label>
			<textarea class="form-control" id="description_vi" name="description_vi" rows="20"></textarea>
		</div>
		<?php echo ckeditor("description_vi", 350, "100%"); ?>
                      </div>

                      </div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label for="">Danh mục</label>
			<select class="form-control" name="parent">
				<option value="0">--Chọn danh mục--</option>
				<?php cate_parent($parent); ?>
				<option></option>
			</select>
		</div>
		  <div class="form-group mt-1">
                      <input name="status" type="checkbox" id="switcherySize1" class="switchery" value="1" checked/>
                      <label for="switcherySize1" class="font-medium-2 ml-1">Kích hoạt</label>

                    </div>
		<div class="form-group">
			<input type="submit" class="btn btn-primary" id="" name="" value="Submit">
		</div>
	</div>
	</div><!-- .row -->
     </form>

</div><!-- .container -->
              </div> <!--. card-body -->
              </div>
            </div>
          </div>
	      </div>
      </div>
</div>

@stop

@push('scripts')
     <script src="/public/app-assets/vendors/js/forms/toggle/bootstrap-checkbox.min.js"
  type="text/javascript"></script>
  <script src="/public/app-assets/vendors/js/forms/toggle/switchery.min.js" type="text/javascript"></script>
   <script src="/public/app-assets/js/scripts/forms/switch.js" type="text/javascript"></script>

@endpush
