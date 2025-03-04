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
                <h4 class="card-title">Thêm bài viết</h4>
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
     <form class="form-horizontal" action="{!! route("cmspanel.product.postAdd") !!}" method="post">
	{{ csrf_field() }}
	<div class="row">
	<div class="col-md-8">
		<div class="form-group">
			<label for="">Tiêu đề</label>
			<input type="" class="form-control" id="" name="name" placeholder="">
		</div>
		<div class="form-group">
			<label for="">Đường dẫn</label>
			<input type="" class="form-control" id="" name="ident" placeholder="">
		</div>
		<div class="form-group">
			<label for="">Giới thiệu ngắn:</label>
			<textarea class="form-control" id="shortDescription" name="shortDescription" rows="20"></textarea>
			<?php echo ckeditor("shortDescription", 200, "100%"); ?>
		</div>

		<div class="form-group">
			<label for="">Nội dung</label>
			<textarea class="form-control" id="description" name="description" rows="20"></textarea>
			<?php echo ckeditor("description", 350, "100%"); ?>
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
                      <label for="switcherySize1" class="ml-1">Kích hoạt</label>

            </div>
           <div class="form-group mt-1">
                      <input name="featured" type="checkbox" id="switcherySize1" class="switchery" value="1"/>
        <label for="switcherySize1" class="ml-1">Tiêu biểu</label>

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
