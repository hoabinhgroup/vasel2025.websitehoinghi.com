@extends('theme::layouts.master')
@section('content')
	@php
		use Modules\Payment\Enums\PaymentMethodEnum;
	@endphp
	<style>
		.general-information-title {
			display: flex;
			flex-direction: row;
			align-items: center;
		}

		.general-information-category .radio-inline {
			display: flex;
			column-gap: 5px;
		}

		.general-information-title .radio-inline {
			display: flex;
			column-gap: 5px;
		}

		body .help-block {
			color: red !important;
		}

		.dietary-radio {
			display: flex;
			align-items: center;
		}

		.form-horizontal {
			background: #ffffff;
			border-radius: 5px;
			padding: 20px;
			box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
		}

		h3.sub-tit {
			color: #005696;
			margin-bottom: 20px;
		}

		.other-specify {
			width: 500px;
			display: flex;
			align-items: center;
		}

		.other-specify .form-group {
			width: 220px;
			margin-bottom: 0px;
		}

		/* Form Group Styles */
		.form-group {
			margin-bottom: 15px;
		}

		label {
			font-weight: bold;
			color: #333;
		}

		input[type="text"],
		input[type="email"],
		input[type="number"],
		select {
			width: 100%;
			padding: 10px;
			border: 1px solid #ced4da;
			border-radius: 4px;
			transition: border-color 0.3s;
		}

		input[type="text"]:focus,
		input[type="email"]:focus,
		input[type="number"]:focus,
		select:focus {
			border-color: #005696;
			outline: none;
		}

		/* Radio and Checkbox Styles */
		.radio-inline {
			margin-right: 15px;
		}


		/* Button Styles */
		#registration_button {
			background-color: #005696;
			color: white;
			border: none;
			padding: 10px 20px;
			border-radius: 5px;
			cursor: pointer;
			transition: background-color 0.3s;
		}

		#registration_button:hover {
			background-color: #004080;
		}

		/* Spinner Styles */
		.spinner {
			border: 2px solid #f3f3f3;
			border-top: 2px solid #3498db;
			border-radius: 50%;
			width: 12px;
			height: 12px;
			animation: spin 1s linear infinite;
			display: inline-block;
		}

		@keyframes spin {
			0% {
				transform: rotate(0deg);
			}

			100% {
				transform: rotate(360deg);
			}
		}

		/* Responsive Styles */
		@media (max-width: 768px) {
			.form-horizontal {
				padding: 15px;
			}

			#registration_button {
				width: 100%;
			}
		}

		#unc_section {
			display: none;
		}
	</style>
	@php
		if (isset($_GET['edit']) && $_GET['edit'] > 0) {
			$registration = \Modules\Registration\Entities\InviteeRegistrationVn::find($_GET['edit']);
		} else {
			$registration = new \Modules\Registration\Entities\InviteeRegistrationVn;
		}
	@endphp

	<div id="wrap" class="container">
		<div class="contents" id="">
			<div class="sub-conbox inner-layer">
				<div class="sub-tit-wrap">
					<h3 class="sub-tit">
						ĐĂNG KÝ THAM DỰ VỚI TƯ CÁCH ĐẠI BIỂU
					</h3>
				</div>

				<form action="{{ route('invitee.registration.vn.submit') }}" id="payment-registration"
					class="form-horizontal col-md-12 col-md-offset-0" method="POST" enctype="multipart/form-data">
					@csrf
					@if (isset($_GET['edit']) && $_GET['edit'] > 0)
						<input type="hidden" name="id" value="{{ $registration->id }}">
					@endif

					<?php $array_title = ['GS', 'PGS', 'TS', 'ThS', 'BSCKII', 'BSCKI', 'BS', 'ĐD', 'KTV'];
					$registration_title = $registration_title = $registration->arr_title;
					?>
					<div class="form-group">
						<label for=""><strong>HỌC HÀM/ HỌC VỊ </strong><span style="color:red">*</span>: </label><span
							style="font-style: italic;">(Có thể chọn
							nhiều lựa chọn hoặc chọn mục “Khác" và điền thông tin)</span>
						<div class="row no-gutters">

							<div class="radio-list-title-wrapper">
								<div class="radio-list-title">
									<div class="radio-right">
										@foreach ($array_title as $title)
											<label class="radio-inline">
												<input name="title[]" value="{{ $title }}" type="checkbox"
													@if(in_array($title, $registration_title)) checked @endif>{{ $title }}.
											</label>
										@endforeach

										<label class="radio-inline other-title-wrapper">
											<input name="title[]" value="other" type="checkbox" @if($registration->title_other) checked @endif>Khác

											<input name="titleOther" id="titleOther" class="form-control input-sm"
												value="{{ $registration->title_other ?? '' }}"
												type="text" {{ $registration->title_other == null ? 'disabled' : '' }}>
										</label>
									</div>
								</div>
							</div>
						</div>


					</div>

					<div class="form-group">
						<div class="row no-gutters">
							<label for=""><strong>HỌ VÀ TÊN </strong> <span style="color:red">*</span>:</label>
							<input type="text" class="form-control col-md-12" id="fullname" name="fullname"
								placeholder="Viết hoa chữ cái đầu, đầy đủ và có dấu. VD: Nguyễn Văn Nam"
								value="{{ $registration->fullname }}">
						</div><!-- .row -->
					</div>


					<div class="form-group">
						<div class="row no-gutters">
							<label for=""><strong>ĐƠN VỊ CÔNG TÁC </strong><span style="color:red">*</span>:</label>
							<input type="text" class="form-control col-md-12" id="work" name="work"
								placeholder="Viết đầy đủ tên đơn vị. VD: Bệnh viện Hữu Nghị Việt Đức"
								value="{{ $registration->work }}">
						</div><!-- .row -->

					</div>

					<div class="form-group">
						<div class="row no-gutters">
							<label for=""><strong>CHỨC VỤ </strong> <span style="color:red">*</span>:</label>
							<input type="text" class="form-control col-md-12" id="jobtitle" name="jobtitle"
								placeholder="VD: Trưởng khoa Ngoại Chấn thương. Nếu không nắm giữ chức vụ thì điền Khoa/ Phòng. VD: Khoa Ngoại Chấn thương"
								value="{{ $registration->jobtitle }}">
						</div><!-- .row -->
					</div>

					<div class="form-group">
						<div class="row no-gutters">
							<label for=""><strong>ĐỊA CHỈ LIÊN HỆ </strong><sup style="color:red">*</sup>:</label>
							<input type="text" class="form-control col-md-12" id="address" name="address"
								placeholder="Cung cấp địa chỉ liên hệ chính xác để gửi các thư mời và giấy chứng nhận (nếu có)"
								value="{{ $registration->address }}">
						</div>
					</div>


					<div class="form-group">
						<div class="row no-gutters">
							<label for=""><strong>THƯ ĐIỆN TỬ </strong> <sup style="color:red">*</sup>:</label>
							<input type="email" class="form-control col-md-12" id="email" name="email"
								placeholder="Cung cấp địa chỉ email chính xác để liên hệ"
								value="{{ $registration->email }}">
						</div><!-- .row -->
					</div>

					<div class="form-group">
						<div class="row no-gutters">
							<label for=""><strong>SỐ ĐIỆN THOẠI </strong> <sup style="color:red">*</sup>:</label>
							<input type="phone" class="form-control col-md-12" id="phone" name="phone"
								placeholder="Cung cấp số điện thoại chính xác để liên hệ, gửi các thư mời và giấy chứng nhận (nếu có)"
								value="{{ $registration->phone }}">
						</div><!-- .row -->
					</div>

					<div class="form-group">
						<div class="row no-gutters">
							<label for=""><strong>CMND/CCCD/Hộ chiếu</strong> <sup style="color:red">*</sup>:</label>
							<input type="text" class="form-control col-md-12" id="cid" name="cid"
								placeholder="Số căn cước, Số hộ chiếu" value="{{ $registration->cid }}">
						</div><!-- .row -->
					</div>

					<div class="form-group">
						<div class="row no-gutters">
							<label for=""><strong>Giới tính</strong> <sup style="color:red">*</sup>:</label>
							<div class="col-md-12 margin-left-20 radio-list">

								<label class="radio-inline">
									<input name="gender" value="nam" type="radio" @if($registration->gender == 'nam') checked
									@endif>
									Nam
								</label>

								<label class="radio-inline">
									<input name="gender" value="nữ" type="radio" @if($registration->gender == 'nữ') checked
									@endif> Nữ
								</label>

							</div>

						</div><!-- .row -->
					</div>

					<div class="form-group">
						<div class="row no-gutters">
							<label for=""><strong>NGÀY, THÁNG, NĂM SINH </strong> <sup style="color:red">*</sup>:</label>
							<div class="col-md-12 birthdate-wrapper">

								<div class="birthdate-item">
									<input type="text" class="form-control" id="birthday" name="birthday"
										placeholder="Ngày sinh" value="{{ $registration->birthday }}" />
								</div>
								<div class="birthdate-item">
									<input type="text" class="form-control" id="birthmonth" name="birthmonth"
										placeholder="Tháng sinh" value="{{ $registration->birthmonth }}" />
								</div>
								<div class="birthdate-item">
									<input type="text" class="form-control" id="birthyear" name="birthyear"
										placeholder="Năm sinh" value="{{ $registration->birthyear }}" />
								</div>

							</div>

						</div><!-- .row -->
					</div>

					<div class="form-group">
						<div class="row no-gutters">
							<label for=""><strong>ĐĂNG KÝ THAM DỰ TẬP HUẤN TIỀN HỘI NGHỊ </strong> <sup
									style="color:red">*</sup>:</label>
							<div class="col-md-12 margin-left-20 radio-list">

								<label class="radio-inline">
									<input name="training" value="yes" type="radio" @if($registration->training == 'yes')
									checked @endif> Có
								</label>

								<label class="radio-inline">
									<input name="training" value="no" type="radio" @if($registration->training == 'no')
									checked @endif> Không
								</label>

							</div>
						</div><!-- .row -->
					</div>

					@if(!isset($_GET['edit']) || isset($_GET['edit']) && $registration->training == 'yes')
						<div class="has_training" @if($registration->training == 'yes') style="display:block" @endif>
							@php 
								$array_course = ['GI Surgery', 'Urology', 'Orthopedic Surgery'];
							@endphp
							<div class="form-group">
								<div class="row no-gutters">
									<label for=""><strong>CHUYÊN KHOA HIỆN TẠI ĐANG CÔNG TÁC </strong> <sup
											style="color:red">*</sup>:</label>
									<div class="col-md-12 margin-left-20 radio-list course-list">

										<label class="radio-inline">
											<input name="course" value="Tiêu hóa" type="radio" @if($registration->course == 'Tiêu hóa') checked @endif> Tiêu hóa
										</label>

										<label class="radio-inline">
											<input name="course" value="Tiết niệu" type="radio" @if($registration->course == 'Tiết niệu') checked @endif> Tiết niệu
										</label>
										<label class="radio-inline">
											<input name="course" value="Chấn thương - Chỉnh hình" type="radio"
												@if($registration->course == 'Chấn thương - Chỉnh hình') checked @endif> Chấn
											thương -
											Chỉnh
											hình
										</label>

										<label class="radio-inline course-other">
											<input name="course" value="other_course" type="radio" @if($registration->course !== null && !in_array($registration->course, array_course())) checked @endif>
											Khác
											<input type="text" class="form-control col-md-4" id="other_course"
												name="other_course"
												value="{{ ($registration->course !== null && !in_array($registration->course, array_course())) ? $registration->course : '' }}"
												disabled>
										</label>

									</div>
								</div><!-- .row -->
							</div>

							<div class="form-group">
								<div class="row no-gutters">
									<label for=""><strong>SỐ NĂM KINH NGHIỆM </strong> <sup style="color:red">*</sup>:</label>
									<input type="number" class="form-control col-md-12" id="experience" name="experience"
										placeholder="" value="{{ $registration->experience }}">
								</div><!-- .row -->
							</div>

							<div class="form-group">
								<div class="row no-gutters">
									<label for=""><strong>ĐĂNG KÝ THAM DỰ TIỆC CHIÊU ĐÃI HỘI NGHỊ </strong> <sup
											style="color:red">*</sup>:</label>
									<div class="col-md-12 margin-left-20 radio-list">

										<label class="radio-inline">
											<input name="galadinner" value="yes" type="radio"
												@if($registration->galadinner == 'yes') checked @endif> Có
										</label>


										<label class="radio-inline">
											<input name="galadinner" value="no" type="radio"
												@if($registration->galadinner == 'no') checked @endif> Không
										</label>

									</div>

								</div><!-- .row -->
							</div>


							<div class="form-group">
								<div class="row no-gutters">
									<label for=""><strong>ĐĂNG KÝ THAM DỰ TIỆC CHIÊU ĐÃI HỘI NGHỊ </strong>
										<sup style="color:red">*</sup>:</label>
									<div class="register-course">
									@foreach (courses() as $course_name)
											<label class="radio-inline">
												<input type="radio" class="" name="course_name" value="{{  $course_name  }}"
													@if(isset($registration->course_name) && in_array($course_name, courses()))
													checked @endif>
												{{  $course_name }}
											</label>

										@endforeach
									</div>
								</div><!-- .row -->
							</div>
						</div>
					@endif

					<div class="form-group">
						<div class="row no-gutters">
							<label for=""><strong>HÌNH THỨC NHẬN GIẤY MỜI THAM DỰ HỘI NGHỊ </strong> <sup
									style="color:red">*</sup>:</label>
							<div class="col-md-12 margin-left-20 radio-list">

								<label class="radio-inline">
									<input name="form_invitation" value="soft" type="radio"
										@if($registration->form_invitation == 'soft') checked @endif> Bản mềm
								</label>

								<label class="radio-inline">
									<input name="form_invitation" value="hard" type="radio"
										@if($registration->form_invitation == 'hard') checked @endif> Bản cứng (Vui lòng kiểm
									tra lại
									địa
									chỉ liên hệ, số điện thoại để tránh thất lạc)
								</label>
							</div>
						</div><!-- .row -->
					</div>

					<div class="form-group">
						<div class="row no-gutters">
							<label for=""><strong>HÌNH THỨC NHẬN GIẤY CHỨNG NHẬN BÁO CÁO TẠI HỘI NGHỊ </strong> <sup
									style="color:red">*</sup>:</label>
							<div class="col-md-12 margin-left-20 radio-list">

								<label class="radio-inline">
									<input name="form_certificate" value="soft" type="radio"
										@if($registration->form_certificate == 'soft') checked @endif> Bản mềm
								</label>

								<label class="radio-inline">
									<input name="form_certificate" value="hard" type="radio"
										@if($registration->form_certificate == 'hard') checked @endif> Bản cứng (Vui lòng kiểm
									tra
									lại
									địa
									chỉ liên hệ, số điện thoại để tránh thất lạc)
								</label>
							</div>
						</div><!-- .row -->
					</div>

					<div class="form-group">
						<div class="row no-gutters">
							<label for=""><strong>HÌNH THỨC ĐÓNG PHÍ </strong> <sup style="color:red">*</sup>:</label>
							<div class="col-md-12 margin-left-20 radio-list">

								<label class="radio-inline">
									<input name="payment_form" value="advance" type="radio"
										@if($registration->payment_form == 'advance') checked @endif> Đóng phí trước hội nghị
								</label>


								<label class="radio-inline">
									<input name="payment_form" value="onsite" type="radio"
										@if($registration->payment_form == 'onsite') checked @endif> Đóng trực tiếp tại hội
									nghị
								</label>

							</div>

						</div><!-- .row -->
					</div>


					<div class="form-group">
						<div class="row no-gutters">
							<label for=""><strong>HÌNH THỨC THANH TOÁN </strong> <sup style="color:red">*</sup>:</label>
							<div class="col-md-12">
								<label for="wire_transfer" class="radio-inline">
									<input id="wire_transfer" class="payment_method unc_statement" name="payment_method"
										value="{{ PaymentMethodEnum::BANK_TRANSFER }}" type="radio"
										@if($registration->payment_method == PaymentMethodEnum::BANK_TRANSFER) checked @endif>
									<span class="title_payment">Chuyển khoản</span>
								</label>
								<div class="wire_transfer_description">
									Tên tài khoản: Hội Ngoại khoa và Phẫu thuật nội soi Việt Nam<br />
									Số tài khoản: 113001060002156<br />
									Tên ngân hàng: Ngân hàng TMCP Bắc Á - PGD Hàng Bông - CN Hà Nội<br />
									Nội dung chuyển khoản: HỌ TÊN + ĐƠN VỊ CÔNG TÁC + ĐÓNG PHÍ THAM DỰ VASEL 2025
									<br />

								</div>
							</div>

						</div>

						<div class="row no-gutters">
							<div class="col-md-12">
								<label for="cash_payment" class="radio-inline">
									<input id="cash_payment" name="payment_method" value="{{ PaymentMethodEnum::CASH }}"
										type="radio" @if($registration->payment_method == PaymentMethodEnum::CASH) checked
										@endif> <span class="title_payment">Tiền mặt</span>

								</label>

								<div class="cash_payment_description">
									Văn phòng Hội Ngoại khoa và Phẫu thuật nội soi Việt Nam<br />
									Địa chỉ: Trung tâm Đào tạo và Chỉ đạo tuyến<br />
									Tầng 1, tòa nhà B1, Bệnh viện Hữu nghị Việt Đức - Số 40 Tràng Thi - Hoàn Kiếm - Hà
									Nội<br />


								</div>


							</div>
						</div>


					</div>



					<div id="unc_section" class="form-group" @if ($registration->payment_method == PaymentMethodEnum::BANK_TRANSFER) style="display:block;" @endif>
						<div class="row">
							<div class="file-upload-wrapper" id="uploadUNC" @if (isset($_GET['edit']) && $_GET['edit'] > 0)
							style="display:none;" @endif>
								<!-- Phần hiển thị tên file -->
								<div class="file-upload-filename" id="UNC_name">ĐÍNH KÈM SAO KÊ/ UNC NẾU ĐÃ CHUYỂN
									KHOẢN
								</div>

								<label class="file-upload-label" for="UNC_input">CHỌN FILE</label>

								<input class="file-upload-input" type="file" name="unc_statement" id="UNC_input"
									value="{{ $registration->unc_statement }}">


							</div>
							@if (isset($_GET['edit']) && $_GET['edit'] > 0)
								<ul>
									<li><a href="{{ get_image_url($registration->unc_statement) }}">Download file</a></li>
									<li><a href="javascript:void(0)" onclick="uploadUNC()"> Upload UNC</a></li>
								</ul>
							@endif
						</div>
					</div>



					<button id="registration_button" type="submit" class="btn btn-primary">
						ĐĂNG KÝ
						<span id="spinner" class="spinner" style="display: none;"></span>
					</button>


				</form>
			</div>
		</div>
	</div>

	<script type="text/javascript">
		document.addEventListener("DOMContentLoaded", () => {
			new ConferenceRegistration({
				customTogglePaymentMethod: (target) => {
					const isBankTransfer = target.value === "bank-transfer";
					document.querySelector('.wire_transfer_description').style.display = isBankTransfer ? "block" : "none";
					document.querySelector('.cash_payment_description').style.display = isBankTransfer ? "none" : "block";
					document.getElementById('unc_section').style.display = (isBankTransfer && target.classList.contains("unc_statement")) ? "block" : "none";
				}
			});
		});
	</script>
@endsection