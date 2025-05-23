<?php

namespace Modules\Setting\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MediaSettingRequest extends FormRequest
{
	public function rules(): array
	{
		return apply_filters('cms_media_settings_validation_rules', [
			'media_aws_access_key_id' => 'nullable|string|required_if:media_driver,s3',
			'media_aws_secret_key' => 'nullable|string|required_if:media_driver,s3',
			'media_aws_default_region' => 'nullable|string|required_if:media_driver,s3',
			'media_aws_bucket' => 'nullable|string|required_if:media_driver,s3',
			'media_aws_url' => 'nullable|string|required_if:media_driver,s3',

			'media_wasabi_access_key_id' => 'nullable|string|required_if:media_driver,wasabi',
			'media_wasabi_secret_key' => 'nullable|string|required_if:media_driver,wasabi',
			'media_wasabi_default_region' => 'nullable|string|required_if:media_driver,wasabi',
			'media_wasabi_bucket' => 'nullable|string|required_if:media_driver,wasabi',
			'media_wasabi_root' => 'nullable|string',

			'media_do_spaces_access_key_id' => 'nullable|string|required_if:media_driver,do_spaces',
			'media_do_spaces_secret_key' => 'nullable|string|required_if:media_driver,do_spaces',
			'media_do_spaces_default_region' => 'nullable|string|required_if:media_driver,do_spaces',
			'media_do_spaces_bucket' => 'nullable|string|required_if:media_driver,do_spaces',
			'media_do_spaces_endpoint' => 'nullable|string|required_if:media_driver,do_spaces',

			'media_bunnycdn_hostname' => 'nullable|string|required_if:media_driver,bunnycdn',
			'media_bunnycdn_zone' => 'nullable|string|required_if:media_driver,bunnycdn',
			'media_bunnycdn_key' => 'nullable|string|required_if:media_driver,bunnycdn',
			'media_bunnycdn_region' => 'nullable|string',
		]);
	}
}
