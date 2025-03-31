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
	</style>
	@php
		if (isset($_GET['edit']) && $_GET['edit'] > 0) {
			$registration = \Modules\Registration\Entities\SpeakerRegistrationVn::find($_GET['edit']);
		} else {
			$registration = new \Modules\Registration\Entities\SpeakerRegistrationVn;
		}
	@endphp

	<div id="wrap" class="container">
		<div class="contents" id="">
			<div class="sub-conbox inner-layer">
				<div class="sub-tit-wrap">
					<h3 class="sub-tit">
						ĐĂNG KÝ BÁO CÁO TẠI HỘI NGHỊ
					</h3>
				</div>

				<form action="{{ route('speaker.registration.vn.submit') }}" id="payment-registration"
					class="form-horizontal col-md-12 col-md-offset-0" method="POST" enctype="multipart/form-data">
					@csrf
					@if (isset($_GET['edit']) && $_GET['edit'] > 0)
						<input type="hidden" name="id" value="{{ $registration->id }}">
					@endif
					<h2 class="heading_red">THÔNG TIN BÀI BÁO CÁO</h2>
					<div class="form-group">
						<div class="row no-gutters">
							<label for=""><strong>Tên đề tài</strong><span style="color:red">*</span>:</label>
							<input type="text" class="form-control col-md-12" id="topic" name="topic"
								placeholder="Không viết in hoa toàn bộ tên báo cáo" value="{{ $registration->topic }}">
						</div><!-- .row -->
					</div>
					<div class="form-group">
						<label for=""><strong>LĨNH VỰC BÁO CÁO</strong><span style="color:red">*</span>:</label>
						<div class="row no-gutters">

							<div class="radio-list general-information-title">
								@foreach (report_sessions_vn() as $session_id => $session_name)
									<label class="radio-inline">
										<input name="session" value="{{ $session_name }}" type="radio"
											@if(report_sessions_vn()[$session_id] === $registration->session) checked
											@endif>{{ $session_name }}
									</label>
								@endforeach

								<label class="radio-inline other-specify">
									<div class="other-specify-title">
										<input name="session" value="other_session" type="radio" @if($registration->session !== null && !in_array($registration->session, report_sessions())) checked
										@endif>Khác
									</div>
									<div class="form-group other-session">
										<input name="otherSession" id="sessionOther" class="form-control input-sm"
											value="{{ ($registration->session !== null && !in_array($registration->session, report_sessions_vn())) ? $registration->session : '' }}"
											type="text" {{ ($registration->session == null || in_array($registration->session, report_sessions_vn())) ? 'disabled' : '' }}>
									</div>
								</label>

							</div><!-- .row -->
						</div><!-- .row -->
					</div>
					<div class="form-group">
						<div class="row no-gutters">
							<label for=""><strong>Ngôn ngữ báo cáo</strong> <sup style="color:red">*</sup>:</label>
							<div class="col-md-12 radio-list">

								<label class="radio-inline">
									<input name="report_lang" value="vi" type="radio" @if($registration->report_lang == 'vi')
									checked @endif> Tiếng Việt
								</label>

								<label class="radio-inline">
									<input name="report_lang" value="en" type="radio" @if($registration->report_lang == 'en')
									checked @endif> Tiếng Anh
								</label>
							</div>
						</div><!-- .row -->
					</div>
					<div class="form-group">
						<div class="row no-gutters">
							<label for=""><strong>BÁO CÁO TÓM TẮT & TOÀN VĂN</strong></label>
							<p class="">
								Việc nộp Báo cáo tóm tắt & Báo cáo toàn văn là <span class="bold">KHÔNG</span> bắt buộc ở
								thời điểm
								hiện tại. Quý đại biểu có thể đăng ký tên đề tài trước và tải file lên sau ở bước chỉnh sửa
								thông tin đăng ký.
							<ul class="deadline-submit-abstract">
								<p>Thời hạn nộp báo cáo:</p>
								<li><span>+ Thời gian nộp bài báo cáo tóm tắt (tiếng Việt và tiếng Anh): <strong>trước
											ngày 17/7/2025</strong></span>
									<!-- <input type="text" name="report_deadline_summary" class="datepicker"
																																																								value="{{ $registration->report_deadline_summary ?? '' }}"> -->
								</li>
								<li><span>+ Thời gian nộp bài toàn văn: <strong>trước ngày 15/8/2025</strong></span>
									<!-- <input type="text" name="report_deadline_full" class="datepicker"
																																																								value="{{ $registration->report_deadline_full ?? '' }}"> -->
								</li>
							</ul>
							</p><!-- .row -->
						</div><!-- .row -->
					</div>

					<div class="form-group-attach">
						<div class="form-group">
							<div class="row">
								<div class="file-upload-wrapper">
									<!-- Phần hiển thị tên file -->
									<div class="file-upload-filename" id="report_file_summary_name">FILE BÁO CÁO TÓM TẮT
									</div>

									<!-- Nút chọn file -->
									<label class="file-upload-label" for="report_file_summary_input">CHỌN FILE</label>

									<!-- Input file thật (bị ẩn) -->
									<input class="file-upload-input" type="file" name="report_file_summary"
										id="report_file_summary_input" value="{{ $registration->report_file_summary }}">


								</div>
								@if (isset($_GET['edit']) && $_GET['edit'] > 0)
									<a href="{{ get_image_url($registration->report_file_summary) }}">Download file</a>
								@endif
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="file-upload-wrapper">
									<!-- Phần hiển thị tên file -->
									<div class="file-upload-filename" id="report_file_full_name">FILE BÁO CÁO TOÀN VĂN
									</div>

									<!-- Nút chọn file -->
									<label class="file-upload-label" for="report_file_full_input">CHỌN FILE</label>

									<!-- Input file thật (bị ẩn) -->
									<input class="file-upload-input" type="file" name="report_file_full"
										id="report_file_full_input" value="{{ $registration->report_file_full }}">

								</div>
								@if (isset($_GET['edit']) && $_GET['edit'] > 0)
									<a href="{{ get_image_url($registration->report_file_full) }}">Download file</a>
								@endif
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row no-gutters">
							<label for=""><strong>ĐĂNG KÝ ĐĂNG BÀI TRÊN TẠP CHÍ NGOẠI KHOA VÀ PHẪU THUẬT NỘI SOI VIỆT
									NAM</strong> <sup style="color:red">*</sup>:</label>
							<div class="col-md-12 radio-list">

								<label class="radio-inline">
									<input name="journal_vn" value="yes" type="radio" @if($registration->journal_vn == 'yes')
									checked @endif> Có
								</label>

								<label class="radio-inline">
									<input name="journal_vn" value="no" type="radio" @if($registration->journal_vn == 'no')
									checked @endif> Không
								</label>
							</div>
						</div><!-- .row -->
					</div>

					<?php $array_title = ['GS', 'PGS', 'TS', 'ThS', 'BSCKII', 'BSCKI', 'BS', 'ĐD', 'KTV'];
	$title = $registration->arr_title;

								?>
					<h2 class="heading_red">THÔNG TIN BÁO CÁO VIÊN</h2>
					<div class="form-group">
						<label for=""><strong>Chức danh</strong><span style="color:red">*</span>:</label>
						<div class="row no-gutters">

							<div class="radio-list-title-wrapper">
								<div class="radio-list-title">
									<div class="radio-left">Học hàm:</div>
									<div class="radio-right">
										<label class="radio-inline">
											<input name="title[]" value="GS" type="checkbox" @if(in_array('GS', $title))
											checked @endif>GS.
										</label>
										<label class="radio-inline">
											<input name="title[]" value="PGS" type="checkbox" @if(in_array('PGS', $title))
											checked @endif>PGS.
										</label>
									</div>
								</div>
								<div class="radio-list-title">
									<div class="radio-left">Học vị:</div>
									<div class="radio-right">
										<label class="radio-inline">
											<input name="title[]" value="TS" type="checkbox" @if(in_array('TS', $title))
											checked @endif>TS.
										</label>
										<label class="radio-inline">
											<input name="title[]" value="ThS" type="checkbox" @if(in_array('ThS', $title))
											checked @endif>ThS.
										</label>
										<label class="radio-inline">
											<input name="title[]" value="BSCKII" type="checkbox" @if(in_array('BSCKII', $title)) checked @endif>BSCKII.
										</label>
										<label class="radio-inline">
											<input name="title[]" value="BSCKI" type="checkbox" @if(in_array('BSCKI', $title)) checked @endif>BSCKI.
										</label>
									</div>
								</div>
								<div class="radio-list-title">
									<div class="radio-left">Đối tượng khác:</div>
									<div class="radio-right">
										<label class="radio-inline">
											<input name="title[]" value="BS" type="checkbox" @if(in_array('BS', $title))
											checked @endif>BS.
										</label>
										<label class="radio-inline">
											<input name="title[]" value="ĐD" type="checkbox" @if(in_array('ĐD', $title))
											checked @endif>ĐD.
										</label>
										<label class="radio-inline">
											<input name="title[]" value="KTV" type="checkbox" @if(in_array('KTV', $title))
											checked @endif>KTV.
										</label>
										<label class="radio-inline other-title-wrapper">
											<input name="title[]" value="other" type="checkbox"
												@if($registration->title_other) checked @endif>Khác
											<input name="titleOther" id="titleOther" class="form-control input-sm"
												value="{{ $registration->title_other ?? '' }}" type="text" {{ $registration->title_other == null ? 'disabled' : '' }}>
										</label>
									</div>
								</div>
							</div>
						</div>


					</div>

					<div class="form-group">
						<div class="row no-gutters">
							<label for=""><strong>Họ và tên</strong> <span style="color:red">*</span>:</label>
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
							<label for=""><strong>CHỨC VỤ </strong><span style="color:red">*</span>:</label>
							<input type="text" class="form-control col-md-12" id="jobtitle" name="jobtitle"
								placeholder="VD: Trưởng khoa Ngoại Chấn thương. Nếu không nắm giữ chức vụ thì điền Khoa/ Phòng. VD: Khoa Ngoại Chấn thương"
								value="{{ $registration->jobtitle }}">
						</div><!-- .row -->
					</div>

					<!-- <div class="passport_section form-group" style="display: none">
																																																																																																																																																																																																																																				</div> -->

					<div class="form-group">
						<div class="row no-gutters">
							<label for=""><strong>Địa chỉ liên hệ</strong><sup style="color:red">*</sup>:</label>
							<textarea class="form-control col-md-12" id="address" name="address"
								placeholder="Cung cấp địa chỉ liên hệ chính xác để gửi các chứng nhận và hóa đơn (nếu có). Ban Tổ chức không chịu trách nhiệm về việc thất lạc nếu thông tin cung cấp không chính xác">{{ $registration->address }}</textarea>
						</div>
					</div>


					<div class="form-group">
						<div class="row no-gutters">
							<label for=""><strong>Thư điện tử</strong> <sup style="color:red">*</sup>:</label>
							<input type="email" class="form-control col-md-12" id="email" name="email"
								placeholder="Cung cấp địa chỉ email chính xác để liên hệ"
								value="{{ $registration->email }}">
						</div><!-- .row -->
					</div>

					<div class="form-group">
						<div class="row no-gutters">
							<label for=""><strong>Số điện thoại</strong> <sup style="color:red">*</sup>:</label>
							<textarea class="form-control col-md-12" id="phone" name="phone"
								placeholder="Cung cấp số điện thoại chính xác để liên hệ và gửi các chứng nhận và hóa đơn (nếu có). Ban Tổ chức không chịu trách nhiệm về việc thất lạc nếu thông tin cung cấp không chính xác">{{ $registration->phone }}</textarea>
						</div><!-- .row -->
					</div>

					<div class="form-group">
						<div class="row no-gutters">
							<label for=""><strong>CCCD/Hộ chiếu</strong> <sup style="color:red">*</sup>:</label>
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
									@endif> Nam
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
											Khác. Vui lòng
											điền
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
									<label for=""><strong>ĐĂNG KÝ KHÓA TẬP HUẤN THEO CHUYÊN KHOA </strong>
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
							<label for=""><strong>ĐĂNG KÝ THAM DỰ TIỆC CHIÊU ĐÃI HỘI NGHỊ </strong> <sup
									style="color:red">*</sup>:</label>
							<div class="col-md-12 margin-left-20 radio-list">

								<label class="radio-inline">
									<input name="galadinner" value="yes" type="radio" @if($registration->galadinner == 'yes')
									checked @endif> Có
								</label>


								<label class="radio-inline">
									<input name="galadinner" value="no" type="radio" @if($registration->galadinner == 'no')
									checked @endif> Không
								</label>

							</div>

						</div><!-- .row -->
					</div>

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

					<div class="form-group note-section">
						<div class="row no-gutters">
							<div class="note">
								<p><strong lang="VI">LƯU Ý QUAN TRỌNG</strong></p>
								<p><span lang="VI">-       </span><span lang="VI">Vui lòng nhập chính xác thông tin của Báo
										cáo viên để đảm bảo việc cấp Chứng nhận tham gia Hội nghị.<o:p></o:p></span></p>
								<p><span lang="VI">-       </span><span lang="VI">Chỉ những Báo cáo viên thực tế trình bày
										tại Hội nghị mới được nhận Chứng nhận.<o:p></o:p></span></p>
								<p><span lang="VI">-       </span><span lang="VI">Mọi thay đổi về Báo cáo viên phải được
										thông báo và nhận xác nhận từ Ban Tổ chức ít nhất 48 giờ trước khi Hội nghị diễn ra.
										<o:p></o:p>
									</span></p>
								<p><span lang="VI">-       </span><span lang="VI">Ban Tổ chức không chịu trách nhiệm nếu
										thông tin cung cấp không chính xác hoặc thay đổi không đúng quy định.</span></p>
							</div>
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
			new ConferenceRegistration();
		});

	</script>
@endsection