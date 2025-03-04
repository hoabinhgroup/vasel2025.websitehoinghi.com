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

	@endphp
	<script>
		window.registrations = @json(conferenceFees());
		console.log(window.registrations);
	</script>

	<div id="container" class="">
		<div class="contents" id="">
			<div class="sub-conbox inner-layer">
				<div class="sub-tit-wrap">
					<h3 class="sub-tit">Registration</h3>
				</div>

				<form action="{{ route('payment.registration.submit') }}" id="payment-registration"
					class="form-horizontal col-md-12 col-md-offset-0" method="POST" enctype="multipart/form-data">
					@csrf
					<div id="registration_heading">
						<center>

							<i>Please complete the following details to submit your request.</i>
						</center>


					</div>
					<div class="form-group">
						<div class="row no-gutters">
							<div class="col-md-12">
								<div class="radio-list general-information-category">
									<label class="radio-inline">
										<input name="category" value="FACULTY/INVITED SPEAKERS"
											type="radio"><strong>FACULTY/INVITED SPEAKERS</strong>
									</label>
									<label class="radio-inline">
										<input name="category" value="INTERNATIONAL REGISTRATION"
											type="radio"><strong>INTERNATIONAL REGISTRATION</strong>
									</label>
									<label class="radio-inline">
										<input name="category" value="LOCAL REGISTRATION" type="radio"><strong>LOCAL
											REGISTRATION</strong>
									</label>

								</div><!-- .row -->

							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<h4><label style="margin: 0px;color: #005696" for="">
									GENERAL INFORMATION:</label></h4>
						</div>
						<div class="row no-gutters">
							<label for=""><strong>Title</strong><span style="color:red">*</span>:</label>
							<div class="col-md-12">
								<div class="radio-list general-information-title">
									<label class="radio-inline">
										<input name="title" value="Prof" type="radio">Prof.
									</label>
									<label class="radio-inline">
										<input name="title" value="Dr" type="radio">Dr.
									</label>
									<label class="radio-inline">
										<input name="title" value="M.Sc" type="radio">M.Sc.
									</label>
									<label class="radio-inline">
										<input name="title" value="B.Sc" type="radio">B.Sc.
									</label>
									<label class="radio-inline">
										<input name="title" value="Mr" type="radio">Mr.
									</label>
									<label class="radio-inline">
										<input name="title" value="Ms" type="radio">Ms.
									</label>
									<label class="radio-inline other-specify">
										<div class="other-specify-title">
											<input name="title" value="5" type="radio">Other. Please Specify:
										</div>
										<div class="form-group"
											style="display: flex; flex-direction: column;margin-bottom:0px;">
											<input name="titleOther" id="titleOther" class="form-control input-sm" value=""
												type="text" style="width: auto;" disabled>
										</div>
									</label>

								</div><!-- .row -->

							</div>
						</div>


					</div>

					<div class="form-group">
						<div class="row no-gutters">
							<label for=""><strong>Full name</strong> <span style="color:red">*</span>:</label>
							<input type="text" class="form-control col-md-12" id="fullname" name="fullname" placeholder=""
								value="">
						</div><!-- .row -->
					</div>


					<div class="form-group">
						<div class="row no-gutters">
							<label for=""><strong>Affiliation</strong><span style="color:red">*</span>:</label>
							<input type="text" class="form-control col-md-12" id="affiliation" name="affiliation"
								placeholder="" value="">
						</div><!-- .row -->

					</div>

					<div class="form-group">
						<div class="row no-gutters">
							<label for=""><strong>Position:</strong></label>
							<input type="text" class="form-control col-md-12" id="position" name="position" placeholder=""
								value="">
						</div><!-- .row -->

					</div>

					<div class="form-group">
						<div class="row no-gutters">
							<label for=""><strong>Country/Region </strong><span style="color:red">*</span>:</label>
							<select id="country" name="country" class="form-control">
								<option value="">Please choose your country</option>
								@foreach(allCountries() as $countryCode => $countryName)
									<option value="{{ $countryCode }}">{{ $countryName }}</option>
								@endforeach
							</select>
						</div><!-- .row -->
					</div>

					<div class="passport_section form-group" style="display: none">
						<div class="row no-gutters">
							<div class="col-md-12">
								<label for="input-type">Passport File<sup>*</sup>:</label>
							</div>
						</div>
						<div class="row no-gutters">
							<div class="col-md-12">
								<div class="custom-file-upload">
									<input type="file" class="form-control col-md-4" id="passport" name="passport"
										style="opacity: 0">
									<label for="passport" class="custom-file-upload-label" id="customPassportLabel">Click
										HERE to upload passport file</label>
								</div>

							</div>
						</div><!-- .row -->
					</div>

					<div class="form-group">
						<div class="row no-gutters">
							<label for=""><strong>Mobile Number</strong><sup style="color:red">*</sup>:</label>
							<input type="number" class="form-control col-md-12" id="phone" name="phone" placeholder=""
								value="">
						</div><!-- .row -->
					</div>

					<div class="form-group">
						<div class="row no-gutters">
							<label for=""><strong>Email address</strong> <sup style="color:red">*</sup>:</label>
							<input type="email" class="form-control col-md-12" id="email" name="email" placeholder=""
								value="">
						</div><!-- .row -->
					</div>

					<div class="form-group">
						<div class="row no-gutters">
							<label for=""><strong>Gala dinner</strong> <sup style="color:red">*</sup>:</label>
							<div class="col-md-12 margin-left-20 radio-list">

								<label class="radio-inline">
									<input name="galadinner" value="yes" type="radio"> Yes
								</label>


								<label class="radio-inline">
									<input name="galadinner" value="no" type="radio"> No
								</label>

							</div>

						</div><!-- .row -->
					</div>

					<div class="form-group">
						<div class="row no-gutters dietary-wrapper">
							<label for=""><strong>Special dietary requirements</strong> <sup
									style="color:red">*</sup>:</label>
							<div class="col-md-12 margin-left-20 radio-list dietary-radio">

								<label class="radio-inline">
									<input name="dietary" value="None" type="radio"> None
								</label>


								<label class="radio-inline">
									<input name="dietary" value="Halal" type="radio"> Halal
								</label>

								<label class="radio-inline">
									<input name="dietary" value="Vegetarian" type="radio"> Vegetarian
								</label>



								<label class="radio-inline other-specify">
									<input name="dietary" value="other" type="radio">Other. Please Specify:
									<div class="form-group">
										<input name="dietaryOther" id="dietaryOther" class="form-control input-sm" value=""
											type="text" disabled style="width: auto;">
									</div>
								</label>

							</div>

						</div><!-- .row -->
						<div class="row">
						</div>
					</div>



					<div id="registration_table_section">
						<div id="international_registration_table">
							<p><strong>CONFERENCE FEE: EARLY BIRD (USD)</s><span lang="EN-US"> (before March
										25</span>th<span lang="EN-US">, 2025)</strong>
							</p>
							<div class="form-group">
								@include('vasel2025::partials.table.international_registration_table')
							</div>

							<!-- <div id="international_registration_note">
					<p>* Required a proof document (professor's referral letter) <br/>	
				Full registration fee includes participation in conference, Congress documents, coffee and lunch breaks on each day, excluding accommodation.</p>
					</div> -->

						</div>

						<div id="local_registration_table">
							<p><strong>CONFERENCE FEE: EARLY BIRD (USD)</s><span lang="EN-US"> (before March
										25</span>th<span lang="EN-US">, 2025)</strong>
							</p>
							<div class="form-group">
								@include('vasel2025::partials.table.local_registration_table')
							</div>

						</div>

						<input type="hidden" name="totalAmount" id="totalAmount" value="">
						<input type="hidden" name="feeId" id="feeId" value="">

						<p><span lang="EN-US">
								<o:p> </o:p>
							</span></p>
						<table border="1" cellspacing="0" cellpadding="15" style="width: 100%;">
							<tbody>
								<tr>
									<td id="total_cell" width="576">
										<span>TOTAL</span>
									</td>
									<td width="164" valign="top">
										<span id="total" lang="EN-US"></span>
									</td>
								</tr>
							</tbody>
						</table>
					</div>

					<p>&nbsp;</p>

					<div id="local_registration_table">
						<p><strong>CONFERENCE FEE: EARLY BIRD (USD) </s><span lang="EN-US"> (before March 25th,
									2025)</strong>
						</p>

					</div>



					<div id="payment_method_section">
						<div class="form-group">
							<div class="row">
								<div class="col-md-10">
									<h4><label style="margin: 15px 0px;color: #005696" for="">
											PAYMENT METHOD:</label></h4>
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="row no-gutters">
								<div class="col-md-12">
									<label for="online_payment" class="radio-inline">
										<input id="online_payment" name="payment_method"
											value="{{ PaymentMethodEnum::ONEPAY_PAYMENT }}" type="radio"> <span
											class="title_payment">ONLINE PAYMENT</span> (5% transaction fee will
										be applied)

									</label>

									<div class="online_payment_description">
										Some errors that may cause the transaction to fail include: <br />
										- Incorrect card information entered.<br />
										- Payment exceeding the card's limit.<br />
										- Payment declined by the issuing bank due to an amount higher than
										usual transactions.<br />
										In case of a failed payment, please contact the issuing bank to confirm
										the purpose of the transaction if necessary.<br />
									</div>


								</div>
							</div>

							<div class="row no-gutters">
								<div class="col-md-12">
									<label for="wire_transfer" class="radio-inline">
										<input id="wire_transfer" name="payment_method"
											value="{{ PaymentMethodEnum::BANK_TRANSFER }}" type="radio"> <span
											class="title_payment">WIRE TRANSFER</span> (Bank charges must be
										paid at your expense)
									</label>
									<div class="wire_transfer_description">
										<p>Account Holder: <strong>HOA BINH INTERNATIONAL TOUR CO.,
												LTD</strong><br />Account number: <strong>0011.0033.12740 (VND)
												| 0011.3733.12796 (USD)</strong><br />Bank: <strong>Vietcombank
												- 31-33 Ngo Quyen Street, Hoan Kiem district,
												Hanoi</strong><br />Citad: <strong>01203001</strong><br />Swift
											code: <strong>BFTVVNVX001</strong></p>
										<p>Please indicate, "<strong>Full name - Registration ID paid for
												APSCVIR19</strong>” as a reference and send proof of payment to.
										</p>

									</div>
								</div>

							</div>
						</div>
					</div>
					<div class="form-group">

						<button id="registration_button" type="submit" class="btn btn-primary">
							SUBMIT
							<span id="spinner" class="spinner" style="display: none;"></span>
						</button>

					</div>

				</form>
			</div>
		</div>
	</div>


@endsection