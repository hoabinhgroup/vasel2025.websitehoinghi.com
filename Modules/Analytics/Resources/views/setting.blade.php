<div class="flexbox-annotated-section">

<div class="flexbox-annotated-section-annotation">
	<div class="annotated-section-title pd-all-20">
		<h2>Cấu hình Google Analytics</h2>
	</div>
	<div class="annotated-section-description pd-all-20 p-none-t">
		<p class="color-note">Cấu hình analytics....</p>
	</div>
</div>

<div class="flexbox-annotated-section-content">
	<div class="wrapper-content pd-all-20">
		<div class="form-group">
			<label class="text-title-field" for="admin_email">{{ trans('analytics::analytics.settings.tracking_code') }}</label>
			<input type="text" class="next-input" name="google_analytics" id="google_analytics" value="{{ setting('google_analytics') }}">
		</div>
		
		 <div class="form-group">
			<label class="text-title-field" for="admin_email">{{ trans('analytics::analytics.settings.view_id') }}</label>
			<input type="text" class="next-input" name="analytics_view_id" id="analytics_view_id" value="{{ setting('analytics_view_id') }}">
		</div>
		
		<div class="form-group">
		<label class="text-title-field" for="admin_email">{{ trans('analytics::analytics.settings.json_credential') }}</label>
		<textarea type="text" class="next-input" rows="5" name="analytics_service_account_credentials" id="analytics_service_account_credentials">{{ setting('analytics_service_account_credentials') }}</textarea>
	</div>

	</div>
</div>

</div>
