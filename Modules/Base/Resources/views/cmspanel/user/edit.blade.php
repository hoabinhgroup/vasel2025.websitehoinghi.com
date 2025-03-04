@extends('cmspanel/layout/dashboard')

@section('title',' - Sửa Menu')

@push('styles')
     <link rel="stylesheet" type="text/css" href="/public/app-assets/vendors/css/forms/toggle/switchery.min.css">
     <link rel="stylesheet" type="text/css" href="/public/app-assets/css/plugins/forms/switch.css">
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
                <h4 class="card-title">Sửa thành viên</h4>
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
     <form class="form-horizontal" action="{!! route("cmspanel.user.postEdit", $data['id']) !!}" method="post" enctype="multipart/form-data">	
	{{ csrf_field() }}
	<div class="row">
	<div class="col-md-8">
		<div class="form-group">
			<label for="">Tên thành viên</label>
			<input type="text" class="form-control" id="" name="name" placeholder="" value="{!! old('name', isset($data)? $data['name']: null) !!}">
		</div>
		<div class="form-group">
			<label for="">Email</label>
			<input type="text" class="form-control" id="" name="email" placeholder="" value="{!! old('email', isset($data)? $data['email']: null) !!}">
		</div>
		
		<div class="form-group">
			<label for="">Mật khẩu</label>
			<input type="password" class="form-control" id="" name="password" placeholder="" value="">
		</div>
		
		<div class="form-group">
			<label for="">Vai trò</label>
			<select class="form-control" name="role_id">
				<option value="0">--Chọn danh mục--</option>
				<?php selectbox($parent, '--', $role_id); ?>
				
			</select>
		</div>
				
	</div>
	<div class="col-md-4">	
		<div class="form-group">
			<label for="">Ảnh đại diện</label>
			   <input type="file" name="cover" value="{!! old('picture', isset($data)? $data['picture']: null) !!}">
		</div>
		
		 
			@if($data['picture'] != null)
			<img width="200" src="/public/upload/profile/{!! old('id', $data['id'] ) !!}/{!! old('cover', $data['picture'] ) !!}">
			@else
			
			@endif
			
		
		  <div class="form-group mt-1">
                      <input name="status" type="checkbox" id="switcherySize1" class="switchery" value="1" {!! old('status', ($data['status'] == 1)?' checked': '') !!}/>
                      <label for="switcherySize1" class="ml-1">Kích hoạt</label>
                     
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
