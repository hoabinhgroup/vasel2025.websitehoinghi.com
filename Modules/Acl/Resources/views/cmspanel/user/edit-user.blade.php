@extends('base::cmspanel.layout.dashboard')
@push('styles')
<style>
	.content-box{
		margin-top: 20px;
	}
	.nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active{
		border-top: 1px solid #ddd;
		border-left: 1px solid #ddd;
		border-right: 1px solid #ddd;
	}
	.profile-image{
		width: 200px;
	}
	#update-profile-form{
		text-align: center;
	}
	.mt20{
		margin-top: 20px;
	}
</style>
<link rel="stylesheet" type="text/css" href="/assets/css/jquery-ui.custom.css">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pretty-checkbox@3.0/dist/pretty-checkbox.min.css">
@php
\Assets::addCss(themes('css/slim.min.css'));
\Assets::addJs(themes('js/slim.jquery.min.js'));
\Assets::addJs(themes('js/slim.kickstart.min.js'));
@endphp
@endpush

@section('sidebar')
	@parent
@stop

@push('scripts')

@endpush
@section('content')
	<div class="content-body">
		<div class="row">
			<div class="col-2">
				<form id="update-profile-form" enctype="multipart/form-data" method="POST" action="{{ route('user.profile.image', $user->id) }}">
                <div class="form-group">
                <div class="slim profile-image avatar"
                 data-label="Kéo thả ảnh vào đây"
                 data-size="300,300"
                 data-ratio="1:1"
                 data-will-remove="imageWillBeRemoved"
                 @if($user->profile_image)
                 data-did-remove="imageRemoved"
                 @endif
                 >
                 @if($user->profile_image)
                 <img src="{{ asset('uploads/avatar/' . $user->id .'/'. $user->profile_image) }}" alt=""/>
                 @endif
                <input type="file" name="slim[]" required />
            </div>
			<button type="submit" class="btn btn-success mt20">Upload now!</button>
                </div>
				</form>
			</div>
	 		<div class="col-10">
				<div class="profile-content">
					<div class="tabbable-custom">
						<ul class="nav nav-tabs">
							<li class="nav-item">
								<a href="#tab_1_1" class="nav-link active" data-toggle="tab" aria-expanded="true">{{ trans('acl::user.info') }}</a>
							</li>						
							<li class="nav-item">
								<a href="#tab_1_3" class="nav-link" data-toggle="tab" aria-expanded="false">{{ trans('acl::user.change_password') }}</a>
							</li>						
							{!! apply_filters(ACL_FILTER_PROFILE_FORM_TABS, null) !!}
						</ul>
						<div class="tab-content">
						<!-- PERSONAL INFO TAB -->
						<div class="tab-pane active" id="tab_1_1">
							<div class="card">
								<div class="card-content collapse show">
								  <div class="card-body">
									  <div class="content-box">
										  {!! $form !!}
									   </div>
								  </div><!--.card-body-->
								 </div><!-- .card-content -->
						  </div>
						</div>
						<!-- END PERSONAL INFO TAB -->
						<!-- CHANGE PASSWORD TAB -->
						<div class="tab-pane" id="tab_1_3">
							<div class="card">
								<div class="card-content collapse show">
								  <div class="card-body">
									  <div class="content-box">
										 {!! $passwordForm !!}
									   </div>
								  </div><!--.card-body-->
								 </div><!-- .card-content -->
						  </div>					
						</div>
						<!-- END CHANGE PASSWORD TAB -->
						{!! apply_filters(ACL_FILTER_PROFILE_FORM_TAB_CONTENTS, null) !!}
					</div>
					</div>
				</div>
		  	</div>
		</div>
	</div>

@stop

@push('scripts')
 <script src="/assets/js/bootstrap-multiselect.js" type="text/javascript"></script>

 <script>
	var id = '{{ $user->id }}';
	var DELETE_AVATAR_URL = '{{ route("user.avatar.delete", $user->id) }}';
	function imageWillBeRemoved(data, remove) {
		if (window.confirm("Bạn muốn xóa ảnh đại diện?")) {
			remove();
		}
	}
	
	function imageRemoved(data)
	{

		let dataString = 'name=' + data.input.name + '&id=' + id;
		$.ajax({
				type: "DELETE",
				url: DELETE_AVATAR_URL,
				data: dataString,
				dataType: 'json',
				success: function(data){
				  console.log(data);
				  $('.slim').removeAttr('data-will-remove');
				}
			});
	  console.log('imageRemoved', data);
	
	
	}
</script>

@if(Session::has('success_msg'))
<script> $(function() { $(document).ready(function(){
	appAlert.success("{{ Session::get('success_msg') }}", {container: 'body', duration: 3000});
}); }); </script>
@endif

@if(Session::has('error_msg'))
<script> $(function() { $(document).ready(function(){
	appAlert.error("{{ Session::get('error_msg') }}", {container: 'body', duration: 5000});
}); }); </script>
@endif

@endpush

