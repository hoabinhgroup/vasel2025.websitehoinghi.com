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
			width: 100%
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
			$registration = \Modules\Registration\Entities\SpeakerRegistration::find($_GET['edit']);
		} else {
			$registration = new \Modules\Registration\Entities\SpeakerRegistration;
		}
	@endphp

	<div id="wrap" class="container">
		<div class="contents" id="">
			<div class="sub-conbox inner-layer">
				<div class="sub-tit-wrap">
					<h3 class="sub-tit">
						SPEAKER REGISTRATION FORM
					</h3>
				</div>

				<form action="{{ route('speaker.registration.submit') }}" id="payment-registration"
					class="form-horizontal col-md-12 col-md-offset-0" method="POST" enctype="multipart/form-data">
					@csrf

					@if (isset($_GET['edit']) && $_GET['edit'] > 0)
						<input type="hidden" name="id" value="{{ $registration->id }}">
					@endif
					<h2 class="heading_red">PRESENTATION INFORMATION</h2>
					<div class="form-group">
						<div class="row no-gutters">
							<label for=""><strong>Topic</strong><span style="color:red">*</span>:</label>
							<input type="text" class="form-control col-md-12" id="topic" name="topic" placeholder=""
								value="{{ $registration->topic }}">
						</div><!-- .row -->
					</div>
					<div class="form-group">
						<label for=""><strong>Session</strong><span style="color:red">*</span>:</label>
						<div class="row no-gutters">

							<div class="radio-list general-information-title">
								@foreach (report_sessions() as $session_id => $session_name)
									<label class="radio-inline">
										<input name="session" value="{{ $session_name }}" type="radio"
											@if(report_sessions()[$session_id] === $registration->session) checked
											@endif>{{ $session_name }}
									</label>
								@endforeach

								<label class="radio-inline other-specify">
									<div class="other-specify-title">
										<input name="session" value="other_session" type="radio" @if($registration->session !== null && !in_array($registration->session, report_sessions())) checked
										@endif>Other
									</div>
									<div class="form-group other-session">
										<input name="otherSession" id="sessionOther" class="form-control input-sm"
											value="{{ ($registration->session !== null && !in_array($registration->session, report_sessions())) ? $registration->session : '' }}"
											type="text" {{ ($registration->session == null || in_array($registration->session, report_sessions())) ? 'disabled' : '' }}>
									</div>
								</label>

							</div><!-- .row -->
						</div><!-- .row -->
					</div>
					<div class="form-group">
						<div class="row no-gutters">
							<label for=""><strong>Language</strong> <sup style="color:red">*</sup>:</label>
							<div class="col-md-12 radio-list">

								<label class="radio-inline">
									<input name="report_lang" value="vi" type="radio" @if($registration->report_lang == 'vi')
									checked @endif> Vietnamese
								</label>

								<label class="radio-inline">
									<input name="report_lang" value="en" type="radio" @if($registration->report_lang == 'en')
									checked @endif> English
								</label>
							</div>
						</div><!-- .row -->
					</div>
					<div class="form-group">
						<div class="row no-gutters">
							<label for=""><strong>ABSTRACT & FULL-TEXT ARTICLE</strong></label>
							<p class="">
								Abstracts and full-text articles are not required to be submitted immediately but must be
								sent before the deadline, following the instructions provided in the confirmation email.
							<ul class="deadline-submit-abstract">
								<p>Submission Deadline:</p>
								<li><span>+ Abstract Submission Deadline: <strong>17/7/2025</strong></span>
									<!-- <input type="text" name="report_deadline_summary" class="datepicker"
																																											value="{{ $registration->report_deadline_summary ?? '' }}"> -->
								</li>
								<li><span>+ Full-text Article Submission Deadline: <strong>15/8/2025</strong></span>
									<!-- <input type="text" name="report_deadline_full" class="datepicker"
																																										value="{{ $registration->report_deadline_full ?? '' }}"> -->
								</li>
							</ul>
							</p><!-- .row -->
						</div><!-- .row -->
					</div>

					<div class="form-group-attach">
						<div class="form-group">
							<div class="file-upload-wrapper">
								<!-- Phần hiển thị tên file -->
								<div class="file-upload-filename" id="report_file_summary_name">
									@if (isset($registration->report_file_summary) && $registration->report_file_summary)
										{{ $registration->report_file_summary }}
									@else 
										ABSTRACT FILE
									@endif
								</div>

								<!-- Nút chọn file -->
								<label class="file-upload-label" for="report_file_summary_input">CHOOSE FILE</label>

								<!-- Input file thật (bị ẩn) -->
								<input class="file-upload-input" type="file" name="report_file_summary"
									id="report_file_summary_input" value="{{ $registration->report_file_summary }}">


							</div>
						</div>
						<div class="form-group">
							<div class="file-upload-wrapper">
								<!-- Phần hiển thị tên file -->
								<div class="file-upload-filename" id="report_file_full_name">
									@if (isset($registration->report_file_full) && $registration->report_file_full)
										{{ $registration->report_file_full }}
									@else 
										FULL-TEXT ARTICLE FILE
									@endif	

								</div>

								<!-- Nút chọn file -->
								<label class="file-upload-label" for="report_file_full_input">CHOOSE FILE</label>

								<!-- Input file thật (bị ẩn) -->
								<input class="file-upload-input" type="file" name="report_file_full"
									id="report_file_full_input" value="{{ $registration->report_file_full }}">

							</div>

						</div>
					</div>

					<div class="form-group">
						<div class="row no-gutters">
							<label for=""><strong> PUBLISH ARTICLE IN THE VIETNAM JOURNAL OF SURGERY AND ENDOLAPAROSURGERY
								</strong> <sup style="color:red">*</sup>:</label>
							<div class="col-md-12 radio-list">

								<label class="radio-inline">
									<input name="journal_vn" value="yes" type="radio" @if($registration->journal_vn == 'yes')
									checked @endif> Yes
								</label>

								<label class="radio-inline">
									<input name="journal_vn" value="no" type="radio" @if($registration->journal_vn == 'no')
									checked @endif> No
								</label>
							</div>
						</div><!-- .row -->
					</div>

					<?php $array_title = ['Prof', 'Assoc.Prof', 'Dr', 'MSc', 'BSc', 'Mr', 'Ms'];
					$registration_title = json_decode($registration->title) ?? [];
					?>
					<h2 class="heading_red">SPEAKER INFORMATION</h2>
					<div class="form-group">
						<label for=""><strong>TITLE </strong><span style="color:red">*</span>:</label>
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
											<input name="title[]" value="other" type="checkbox" @if($registration->title_other) checked @endif>Others

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
							<label for=""><strong>FULL NAME</strong> <span style="color:red">*</span>:</label>
							<input type="text" class="form-control col-md-12" id="fullname" name="fullname" placeholder=""
								value="{{ $registration->fullname }}">
						</div><!-- .row -->
					</div>

					<div class="form-group">
						<div class="row no-gutters">
							<label for=""><strong>ORGANIZATION</strong> <span style="color:red">*</span>:</label>
							<input type="text" class="form-control col-md-12" id="organization" name="organization"
								placeholder="" value="{{ $registration->organization }}">
						</div><!-- .row -->
					</div>


					<div class="form-group">
						<div class="row no-gutters">
							<label for=""><strong>POSITION / DEPARTMENT </strong><span style="color:red">*</span>:</label>
							<input type="text" class="form-control col-md-12" id="work" name="work" placeholder=""
								value="{{ $registration->work }}">
						</div><!-- .row -->

					</div>

					<div class="form-group">
						<div class="row no-gutters">
							<label for=""><strong>ADDRESS </strong><sup style="color:red">*</sup>:</label>
							<textarea class="form-control col-md-12" id="address" name="address"
								placeholder="">{{ $registration->address }}</textarea>
						</div>
					</div>


					<div class="form-group">
						<div class="row no-gutters">
							<label for=""><strong>Email</strong> <sup style="color:red">*</sup>:</label>
							<input type="email" class="form-control col-md-12" id="email" name="email" placeholder=""
								value="{{ $registration->email }}">
						</div><!-- .row -->
					</div>

					<div class="form-group">
						<div class="row no-gutters">
							<label for=""><strong>PHONE NUMBER </strong> <sup style="color:red">*</sup>:</label>
							<input type="phone" class="form-control col-md-12" id="phone" name="phone" placeholder=""
								value="{{ $registration->phone }}">
						</div><!-- .row -->
					</div>


					<div class="form-group">
						<div class="row no-gutters">
							<label for=""><strong>Gender</strong> <sup style="color:red">*</sup>:</label>
							<div class="col-md-12 margin-left-20 radio-list">

								<label class="radio-inline">
									<input name="gender" value="nam" type="radio" @if($registration->gender == 'nam') checked
									@endif>
									Male
								</label>

								<label class="radio-inline">
									<input name="gender" value="nữ" type="radio" @if($registration->gender == 'nữ') checked
									@endif> Female
								</label>

							</div>

						</div><!-- .row -->
					</div>

					<div class="form-group">
						<div class="row no-gutters">
							<label for=""><strong>DATE OF BIRTH </strong> <sup style="color:red">*</sup>:</label>
							<div class="col-md-12 birthdate-wrapper">

								<div class="birthdate-item">
									<input type="text" class="form-control" id="birthday" name="birthday" placeholder="DD"
										value="{{ $registration->birthday }}" />
								</div>
								<div class="birthdate-item">
									<input type="text" class="form-control" id="birthmonth" name="birthmonth"
										placeholder="MM" value="{{ $registration->birthmonth }}" />
								</div>
								<div class="birthdate-item">
									<input type="text" class="form-control" id="birthyear" name="birthyear"
										placeholder="YYYY" value="{{ $registration->birthyear }}" />
								</div>

							</div>

						</div><!-- .row -->
					</div>

					<div class="form-group-attach">
						<div class="form-group">
							<label class="shortCV" for="shortCV"><strong>SHORTCV</strong><sup
									style="color:red">*</sup>:</label>
							<div class="file-upload-wrapper">
								<!-- Phần hiển thị tên file -->
								<div class="file-upload-filename" id="shortCV_name">
									@if (isset($registration->shortCV) && $registration->shortCV)
										{{ $registration->shortCV }}
									@else 
										SHORTCV
									@endif
								</div>


								<label class="file-upload-label" for="shortCV_input">CHOOSE FILE</label>


								<input class="file-upload-input" type="file" name="shortCV" id="shortCV_input"
									value="{{ $registration->shortCV }}">

							</div>

						</div>
						<div class="form-group">
							<label class="passport" for="passport"><strong>PASSPORT</strong><sup
									style="color:red">*</sup>:</label>
							<div class="file-upload-wrapper">
								<div class="file-upload-filename" id="passport_name">
									@if (isset($registration->passport) && $registration->passport)
										{{ $registration->passport }}
									@else 
										PASSPORT
									@endif
								</div>

								<label class="file-upload-label" for="passport_input">CHOOSE FILE</label>


								<input class="file-upload-input" type="file" name="passport" id="passport_input"
									value="{{ $registration->passport }}">

							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row no-gutters">
							<label for=""><strong>PRE-CONFERENCE WORKSHOP </strong> <sup style="color:red">*</sup>:</label>
							<div class="col-md-12 margin-left-20 radio-list">

								<label class="radio-inline">
									<input name="training" value="yes" type="radio" @if($registration->training == 'yes')
									checked @endif> Yes
								</label>

								<label class="radio-inline">
									<input name="training" value="no" type="radio" @if($registration->training == 'no')
									checked @endif> No
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
									<label for=""><strong>SPECIALIZED IN </strong> <sup style="color:red">*</sup>:</label>
									<div class="col-md-12 margin-left-20 radio-list course-list">

									
										<label class="radio-inline">
											<input name="course" value="GI Surgery" type="radio" @if($registration->course == 'GI Surgery') checked @endif> GI Surgery
										</label>

										<label class="radio-inline">
											<input name="course" value="Urology" type="radio"
												@if($registration->course == 'Urology') checked @endif> Urology
										</label>
										<label class="radio-inline">
											<input name="course" value="Orthopedic Surgery" type="radio"
												@if($registration->course == 'Orthopedic Surgery') checked @endif> Orthopedic
											Surgery
										</label>

										<label class="radio-inline course-other">
											<input name="course" value="other_course" type="radio" @if($registration->course !== null && !in_array($registration->course, $array_course)) checked @endif>
											Others
											<input type="text" class="form-control col-md-4" id="other_course"
												name="other_course"
												value="{{ ($registration->course !== null && !in_array($registration->course, $array_course)) ? $registration->course : '' }}"
												disabled>
										</label>

									</div>
								</div><!-- .row -->
							</div>

							<div class="form-group">
								<div class="row no-gutters">
									<label for=""><strong>YEARS OF EXPERIENCE </strong> <sup style="color:red">*</sup>:</label>
									<input type="number" class="form-control col-md-12" id="experience" name="experience"
										placeholder="" value="{{ $registration->experience }}">
								</div><!-- .row -->
							</div>

							<div class="form-group">
								<div class="row no-gutters">
									<label for=""><strong>WORKSHOP REGISTRATION</strong>
										<sup style="color:red">*</sup>:</label>
									<div class="register-course">
										<label class="radio-inline">
											<input type="checkbox" class="" name="course_name[]" value="1"
												@if(isset($registration->course_name) && in_array(1, json_decode($registration->course_name))) checked @endif>
											Khóa 1
										</label>
										<label for="">
											<input type="checkbox" class="" name="course_name[]" value="2"
												@if(isset($registration->course_name) && in_array(2, json_decode($registration->course_name))) checked @endif>Khóa 2
										</label>
										<label for="">
											<input type="checkbox" class="" name="course_name[]" value="3"
												@if(isset($registration->course_name) && in_array(3, json_decode($registration->course_name))) checked @endif>Khóa 3
										</label>
									</div>
								</div><!-- .row -->
							</div>
						</div>
					@endif

					<div class="form-group">
						<div class="row no-gutters">
							<label for=""><strong>GALA DINNER REGISTRATION </strong> <sup style="color:red">*</sup>:</label>
							<div class="col-md-12 margin-left-20 radio-list">

								<label class="radio-inline">
									<input name="galadinner" value="yes" type="radio" @if($registration->galadinner == 'yes')
									checked @endif> Yes
								</label>


								<label class="radio-inline">
									<input name="galadinner" value="no" type="radio" @if($registration->galadinner == 'no')
									checked @endif> No
								</label>

							</div>

						</div><!-- .row -->
					</div>



					<div class="form-group note-section">
						<div class="row no-gutters">
							<div class="note">
								<p><strong lang="VI">IMPORTANT NOTICE</strong></p>
								<p><span lang="VI">-       </span><span lang="VI">Please enter the presenter's accurate
										information to ensure the correct issuance of the Certificate of Participation.<o:p>
										</o:p></span></p>
								<p><span lang="VI">-       </span><span lang="VI">Only presenters who deliver their
										presentations at the Conference will receive the Certificate.<o:p></o:p></span></p>
								<p><span lang="VI">-       </span><span lang="VI">Any changes to the presenter must be
										notified and approved by the Organizing Committee at least 48 hours before the
										Conference.
										<o:p></o:p>
									</span></p>
								<p><span lang="VI">-       </span><span lang="VI">The Organizing Committee is not
										responsible for any inaccuracies or unauthorized changes.</span></p>
							</div>
						</div>
					</div>



					<button id="registration_button" type="submit" class="btn btn-primary">
						REGISTER
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