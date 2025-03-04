@extends('base::cmspanel.layout.dashboard')

@section('title',' - Thay đổi mật khẩu')

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
	.error{
		color: red;
	}
	.form-group-password{
		position: relative;
	}
	.show-hide-password{
		position: absolute;
		right: 2px;
		top: 29px;
	}
</style>

@endpush

@section('sidebar')
	@parent
@stop

@push('scripts')

@endpush

@section('content')
<div class="content-wrapper">
 	<div class="card-header">
<h3 class="card-title">Thay đổi mật khẩu cho {{ \Modules\Acl\Entities\Users::find($id)->email}}</h3>
      </div>
	<div class="content-body">
	      <div class="row">
 	<div class="col-12">
            <div class="card">

               <div class="card-content collapse show">
                <div class="card-body">

 <div class="content-box">

		{{ Form::open(array('route' => ['user.changePassword', $id ?? ''],'id' => 'userForm')) }}
			<div class="row">
				<div class="col-md-6">
				<div class="row">
					<div class="col-md-12">
						<div class="form-group form-group-password">
				{{ Form::label('password', 'Nhập mật khẩu mới:') }}
				{{ Form::password('password', [
						'class' => 'form-control',
						'data-rule-required' => 'true',
						'data-rule-validatePassword' => 'true',
						'data-msg-required' => 'Bắt buộc nhập'
						]) }}
						 <div class="input-group-append show-hide-password">
							<span class="input-group-text toggle-password" style="cursor: pointer;">
								<i class="fa fa-eye-slash" aria-hidden="true"></i>
							</span>
						</div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group form-group-password">
				{{ Form::label('password_confirmation', 'Nhập lại mật khẩu:') }}
				{{ Form::password(
					'password_confirmation',
					 	[
					 	  'class' => 'form-control',
					 	  'data-rule-required' => 'true',
					 	  'data-msg-required' => 'Bắt buộc nhập',
					 	  'data-rule-equalto' => '#password',
					 	  'data-msg-equalto' => 'Mật khẩu không khớp'
					 	  ]) }}
						  <div class="input-group-append show-hide-password">
							<span class="input-group-text toggle-password" style="cursor: pointer;">
								<i class="fa fa-eye-slash" aria-hidden="true"></i>
							</span>
						</div>
					 	</div>
					</div>
				</div><!-- .row -->


				<div class="form-group">
					{!! Form::button('<i class="icon-check"></i> Lưu', ['type' => 'submit', 'class' => 'btn btn-info'] ) !!}
				</div>
			</div>
			</div><!-- .row -->

			{{ Form::close() }}
 </div>

                </div><!--.card-body-->
               </div><!-- .card-content -->
            </div>
          </div>
	      </div>
	</div>
</div>
@stop

@push('scripts')

<script>
$(function() {

	document.querySelectorAll('.toggle-password').forEach(function(toggle) {
        toggle.addEventListener('click', function() {
            const input = this.parentElement.parentElement.querySelector('input');
            const icon = this.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            }
        });
    });

$.validator.addMethod("validatePassword", function (value, element) {
            return this.optional(element) || /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,16}$/i.test(value);
        }, "Hãy nhập password từ 8 đến 16 ký tự bao gồm chữ hoa, chữ thường và ít nhất một chữ số");


    $("#userForm").louisForm({
            	onAjaxSuccess: function(result){
	            	console.log('onAjaxSuccess',result);
	            if(result.success){
	            	appAlert.success('ok', {container: 'body', duration: 3000});
	            	window.location.href = '{{ route("user.index") }}';
	            	}
            	},
				onError: function(response) {
					console.log(response);
				},
			});

});


	</script>
@endpush
