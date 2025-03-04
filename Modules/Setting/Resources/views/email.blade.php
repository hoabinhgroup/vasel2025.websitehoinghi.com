@extends('base::cmspanel.layout.dashboard')
@section('content')
   <style>
	   .max-width-1200 {
	max-width: 1200px;
	margin: 0 auto;
		}
		.flexbox-annotated-section {
	margin-bottom: 2rem;
}
.flexbox-annotated-section {
	display: flex;
	flex-wrap: wrap;
	justify-content: center;
	max-width: 103.6rem;
	margin: 0 auto 2rem;
}
@media (min-width: 768px)
.flexbox-annotated-section-annotation, .flexbox-annotated-section-content {
	padding: 0 20px;
}
.flexbox-annotated-section-annotation {
	flex: 1 0 24rem;
}
.pd-all-20 {
	padding: 20px;
}
.flexbox-annotated-section-content {
	flex: 2 1 48rem;
	max-width: 100%;
	min-width: 0;
}
.wrapper-content {
	background: #fff;
	border-radius: 3px;
	box-shadow: 0 2px 4px rgba(0,0,0,.1);
}
.text-title-field {
	margin-bottom: 5px;
	font-weight: 400;
	display: block;
	line-height: 15px;
}
.next-input, .next-input--stylized {
	min-width: 75px;
	vertical-align: baseline;
	height: auto;
	margin: 0;
	color: #000;
	-webkit-appearance: none;
	-moz-appearance: none;
	padding: 5px 10px;
	border: 1px solid #c4cdd5;
	border-radius: 3px;
	font-weight: 400;
	line-height: 24px;
	text-transform: none;
	letter-spacing: normal;
	box-sizing: border-box;
	display: block;
	width: 100%;
	transition: all .2s ease-out;
	transition-property: box-shadow,color;
	box-shadow: inset 0 1px 0 0 rgba(63,63,68,.05);
	border-color: #c4cdd5;
	outline: none;
}
.p-none-t {
	padding-top: 0!important;
}
	</style>
	@php

    @endphp
	{!! Form::open(['route' => ['setting.edit']]) !!}
		<div class="max-width-1200">
			<div class="flexbox-annotated-section">

				<div class="flexbox-annotated-section-annotation">
					<div class="annotated-section-title pd-all-20">
						<h2>{{ trans('setting::setting.email-template') }}</h2>
					</div>
					<div class="annotated-section-description pd-all-20 p-none-t">
						<p class="color-note">{{ trans('setting::setting.email-template-des') }}</p>
					</div>
				</div>

				<div class="flexbox-annotated-section-content">
					<div class="wrapper-content pd-all-20">
						<div class="form-group">
							<label class="text-title-field"
								   for="email_port">{{ trans('setting::setting.email.port') }}</label>
							<input type="text" class="next-input" name="email_port" id="email_port"
								   value="{{ setting('email_port') }}">
						</div>


						<div class="form-group">
						<label class="text-title-field"
							   for="email_host">{{ trans('setting::setting.email.server') }}</label>
						<input type="text" class="next-input" name="email_host" id="email_host"
							   value="{{ setting('email_host') }}">
						</div>


						<div class="form-group">
						<label class="text-title-field"
							   for="email_username">{{ trans('setting::setting.email.username') }}</label>
						<input type="text" class="next-input" name="email_username" id="email_username"
							   value="{{ setting('email_username') }}">
						</div>

						<div class="form-group">
						<label class="text-title-field"
							   for="email_password">{{ trans('setting::setting.email.password') }}</label>
						<input type="password" class="next-input" name="email_password" id="email_password"
							   value="{{ setting('email_password') }}">
						</div>

						<div class="form-group">
							<label class="text-title-field"
								   for="email_encryption">{{ trans('setting::setting.email.encryption') }}
							</label>
							<div class="ui-select-wrapper">
								<select name="email_encryption" class="ui-select form-control select-search-full" id="email_encryption">
										<option value="tls" @if (setting('email_encryption') === 'tls') selected @endif>TLS</option>
										<option value="ssl" @if (setting('email_encryption') === 'ssl') selected @endif>SSL</option>
								</select>

							</div>
						</div>

						<div class="form-group">
						<label class="text-title-field"
							   for="email_from_name">{{ trans('setting::setting.email.from_name') }}</label>
						<input type="text" class="next-input" name="email_from_name" id="email_from_name"
							   value="{{ setting('email_from_name') }}">
						</div>

						<div class="form-group">
						<label class="text-title-field"
							   for="email_from_address">{{ trans('setting::setting.email.from_address') }}</label>
						<input type="text" class="next-input" name="email_from_address" id="email_from_address"
							   value="{{ setting('email_from_address') }}">
						</div>

					</div>
				</div>

			</div>

			<div class="flexbox-annotated-section" style="border: none">
			<div class="flexbox-annotated-section-annotation">
				&nbsp;
			</div>
			<div class="flexbox-annotated-section-content">
				<button class="btn btn-info" type="submit">{{ trans('setting::setting.save_settings') }}</button>
			</div>
			</div>

			<div class="flexbox-annotated-section">






		</div>



		</div>
	{!! Form::close() !!}

	{!! do_action(BASE_FILTER_EMAIL_AFTER_SETTING_CONTENT, null) !!}
@endsection
