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
	{!! Form::open(['route' => ['setting.media.edit']]) !!}
	<div class="max-width-1200">
		<div class="flexbox-annotated-section">

			<div class="flexbox-annotated-section-annotation">
				<div class="annotated-section-title pd-all-20">
					<h2>{{ trans('Setting::setting.media.title') }}</h2>
				</div>
				<div class="annotated-section-description pd-all-20 p-none-t">
					<p class="color-note">{{ trans('Setting::setting.media.description') }}</p>
				</div>
			</div>

			<div class="flexbox-annotated-section-content">
				<div class="wrapper-content pd-all-20">
					<div class="form-group">
						<label class="text-title-field"
							   for="media_driver">{{ trans('Setting::setting.media.driver') }}
						</label>
						<div class="ui-select-wrapper">
							<select name="media_driver" class="ui-select" id="media_driver">
								<option value="public" @if (config('filesystems.default') === 'public') selected @endif>Public</option>
								<option value="s3" @if (config('filesystems.default') === 's3') selected @endif>Amazon S3</option>
								<option value="do_spaces" @if (config('filesystems.default') === 'do_spaces') selected @endif>Digital Ocean</option>
								<option value="cloudinary" @if (config('filesystems.default') === 'cloudinary') selected @endif>Cloudinary</option>
							</select>
						</div>
					</div>

					<div class="s3-config-wrapper" @if (config('filesystems.default') !== 's3') style="display: none;" @endif>
						<div class="form-group">
							<label class="text-title-field"
								   for="media_aws_access_key_id">{{ trans('Setting::setting.media.aws_access_key_id') }}</label>
							<input type="text" class="next-input" name="media_aws_access_key_id" id="media_aws_access_key_id"
								   value="{{ config('filesystems.disks.s3.key') }}" placeholder="Ex: AKIAIKYXBSNBXXXXXX">
						</div>
						<div class="form-group">
							<label class="text-title-field"
								   for="media_aws_secret_key">{{ trans('Setting::setting.media.aws_secret_key') }}</label>
							<input type="text" class="next-input" name="media_aws_secret_key" id="media_aws_secret_key"
								   value="{{ config('filesystems.disks.s3.secret') }}" placeholder="Ex: +fivlGCeTJCVVnzpM2WfzzrFIMLHGhxxxxxxx">
						</div>
						<div class="form-group">
							<label class="text-title-field"
								   for="media_aws_default_region">{{ trans('Setting::setting.media.aws_default_region') }}</label>
							<input type="text" class="next-input" name="media_aws_default_region" id="media_aws_default_region"
								   value="{{ config('filesystems.disks.s3.region') }}" placeholder="Ex: ap-southeast-1">
						</div>
						<div class="form-group">
							<label class="text-title-field"
								   for="media_aws_bucket">{{ trans('Setting::setting.media.aws_bucket') }}</label>
							<input type="text" class="next-input" name="media_aws_bucket" id="media_aws_bucket"
								   value="{{ config('filesystems.disks.s3.bucket') }}" placeholder="Ex: louiscms">
						</div>
						<div class="form-group">
							<label class="text-title-field"
								   for="media_aws_url">{{ trans('Setting::setting.media.aws_url') }}</label>
							<input type="text" class="next-input" name="media_aws_url" id="media_aws_url"
								   value="{{ config('filesystems.disks.s3.endpoint') }}" placeholder="Ex: https://s3-ap-southeast-1.amazonaws.com/botble">
						</div>
					</div>
					
					
					<div class="do-config-wrapper" @if (config('filesystems.default') !== 'do_spaces') style="display: none;" @endif>
						<div class="form-group">
							<label class="text-title-field"
								   for="do_spaces_access_key_id">{{ trans('Setting::setting.media.do_spaces_access_key_id') }}</label>
							<input type="text" class="next-input" name="media_do_spaces_access_key_id" id="media_do_spaces_access_key_id"
								   value="{{ config('filesystems.disks.do_spaces.key') }}" placeholder="Ex: AKIAIKYXBSNBXXXXXX">
						</div>
						<div class="form-group">
							<label class="text-title-field"
								   for="media_do_spaces_secret_key">{{ trans('Setting::setting.media.do_spaces_secret_key') }}</label>
							<input type="text" class="next-input" name="media_do_spaces_secret_key" id="media_do_spaces_secret_key"
								   value="{{ config('filesystems.disks.do_spaces.secret') }}" placeholder="Ex: +fivlGCeTJCVVnzpM2WfzzrFIMLHGhxxxxxxx">
						</div>
						<div class="form-group">
							<label class="text-title-field"
								   for="media_do_spaces_default_region">{{ trans('Setting::setting.media.do_spaces_default_region') }}</label>
							<input type="text" class="next-input" name="media_do_spaces_default_region" id="media_do_spaces_default_region"
								   value="{{ config('filesystems.disks.do_spaces.region') }}" placeholder="Ex: ap-southeast-1">
						</div>
						<div class="form-group">
							<label class="text-title-field"
								   for="media_do_spaces_bucket">{{ trans('Setting::setting.media.do_spaces_bucket') }}</label>
							<input type="text" class="next-input" name="media_do_spaces_bucket" id="media_do_spaces_bucket"
								   value="{{ config('filesystems.disks.do_spaces.bucket') }}" placeholder="Ex: louiscms">
						</div>
						<div class="form-group">
							<label class="text-title-field"
								   for="media_do_spaces_endpoint">{{ trans('Setting::setting.media.do_spaces_endpoint') }}</label>
							<input type="text" class="next-input" name="media_do_spaces_endpoint" id="media_do_spaces_endpoint"
								   value="{{ config('filesystems.disks.do_spaces.endpoint') }}" placeholder="Ex: https://sfo2.digitaloceanspaces.com">
						</div>
						<div class="form-group">
							<input type="hidden" name="media_do_spaces_cdn_enabled" value="0">
							<label>
								<input type="checkbox"  value="1" @if (setting('media_do_spaces_cdn_enabled')) checked @endif name="media_do_spaces_cdn_enabled">
								{{ trans('Setting::setting.media.do_spaces_cdn_enabled') }}
							</label>
						</div>
						<div class="form-group">
							<label class="text-title-field"
								   for="media_do_spaces_cdn_custom_domain">{{ trans('Setting::setting.media.media_do_spaces_cdn_custom_domain') }}</label>
							<input type="text" class="next-input" name="media_do_spaces_cdn_custom_domain" id="media_do_spaces_cdn_custom_domain"
								   value="{{ setting('media_do_spaces_cdn_custom_domain') }}" placeholder="{{ trans('Setting::setting.media.media_do_spaces_cdn_custom_domain_placeholder') }}">
						</div>
					</div>
					
								
					<div class="cloudinary-config-wrapper" @if (config('filesystems.default') !== 'cloudinary') style="display: none;" @endif>
						<div class="form-group">
							<label class="text-title-field"
								   for="cloudinary_api_key">{{ trans('Setting::setting.media.cloudinary_api_key') }}</label>
							<input type="text" class="next-input" name="cloudinary_api_key" id="cloudinary_api_key"
								   value="{{ config('filesystems.disks.cloudinary.api_key') }}" placeholder="Ex: AKIAIKYXBSNBXXXXXX">
						</div>
						<div class="form-group">
							<label class="text-title-field"
								   for="cloudinary_api_secret">{{ trans('Setting::setting.media.cloudinary_api_secret') }}</label>
							<input type="text" class="next-input" name="cloudinary_api_secret" id="cloudinary_api_secret"
								   value="{{ config('filesystems.disks.cloudinary.api_secret') }}" placeholder="Ex: +fivlGCeTJCVVnzpM2WfzzrFIMLHGhxxxxxxx">
						</div>
						<div class="form-group">
							<label class="text-title-field"
								   for="cloudinary_cloud_name">{{ trans('Setting::setting.media.cloudinary_cloud_name') }}</label>
							<input type="text" class="next-input" name="cloudinary_cloud_name" id="cloudinary_cloud_name"
								   value="{{ config('filesystems.disks.cloudinary.cloud_name') }}" placeholder="Ex: ap-southeast-1">
						</div>
						<div class="form-group">
							<input type="hidden" name="cloudinary_secure" value="1">
							<label>
								<input type="checkbox" value="1" @if (setting('cloudinary_secure')) checked @endif name="cloudinary_secure">
								{{ trans('Setting::setting.media.cloudinary_secure') }}
							</label>
						</div>
						
						</div>
					</div>
					
					
					

				</div>
			</div>

		</div>

		<div class="flexbox-annotated-section" style="border: none">
			<div class="flexbox-annotated-section-annotation">
				&nbsp;
			</div>
			<div class="flexbox-annotated-section-content">
				<button class="btn btn-info" type="submit">{{ trans('Setting::setting.save_settings') }}</button>
			</div>
		</div>
	</div>
	{!! Form::close() !!}
@endsection

@push('footer')
	<script>
		"use strict";
		$(document).ready(function () {
			$(document).on('change', '#media_driver', function () {
			   if ($(this).val() === 's3') {
				   $('.s3-config-wrapper').show();
			   }else if($(this).val() === 'do_spaces') {
				   $('.do-config-wrapper').show();
				   $('.s3-config-wrapper').hide();
			   } else {
				   $('.do-config-wrapper').hide();
				   $('.s3-config-wrapper').hide();
			   }
			});
		});
	</script>
@endpush
