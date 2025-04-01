@extends('theme::layouts.master')
@section('content')
	<style>
		#description p {
			text-align: center;

		}

		.registrations {
			display: flex;
			justify-content: space-between;
		}

		.registrations a {
			width: 230px;
			height: 100%;
			aspect-ratio: 4/3;
			text-align: center;
			display: flex;
			justify-content: center;
			align-items: center;
			color: #fff;
			text-decoration: none;
			transition: all .3s ease;
		}

		.registrations a:hover {
			opacity: 0.9;
		}

		.registrations a.green {
			background-color: #28a745;
		}

		.registrations a.blue {
			background-color: #005696;
		}
	</style>
	<div id="wrapper" class="container">

		<div id="description">
			<p>VUI LÒNG LỰA CHỌN MẪU ĐĂNG KÝ THEO MỤC ĐÍCH THAM DỰ <br />
				PLEASE CHOOSE THE REGISTRATION FORM BY PURPOSE OF PARTICIPATION
			</p>
		</div>
		<div class="registrations">
			<a href="{{ route('speaker.registration.vn') }}" class="registration-item green">
				ĐĂNG KÝ BÁO CÁO<br />
				TẠI HỘI NGHỊ

			</a>
			<a href="{{ route('speaker.registration') }}" class="registration-item green">
				SPEAKER<br />
				REGISTRATION FORM

			</a>
			<a href="{{ route('invitee.registration.vn') }}" class="registration-item blue">
				THAM DỰ VỚI<br />
				TƯ CÁCH ĐẠI BIỂU

			</a>
			<a href="{{ route('invitee.registration') }}" class="registration-item blue">
				DELEGATE<br />
				REGISTRATION FORM

			</a>
		</div>
	</div>
@endsection