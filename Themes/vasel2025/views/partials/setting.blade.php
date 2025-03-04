{!! Form::open(['route' => ['setting.edit']]) !!}
<div class="max-width-1200">
	<div class="flexbox-annotated-section">
		<div class="flexbox-annotated-section-annotation">
			<div class="annotated-section-title pd-all-20">
				<h2>Email Template Payment Registration</h2>
			</div>
			<div class="annotated-section-description pd-all-20 p-none-t">
				<p class="color-note">Giao diện email template contact</p>
				<div class="available-variable">
					<p><code>{name}</code>: Tên người liên hệ</p>
					<p><code>{email}</code>: Email người liên hệ</p>
					<p><code>{mobile}</code>: Điện thoại liên hệ</p>
					<p><code>{title}</code>: Tiêu đề liên hệ</p>
					<p><code>{message}</code>: Tiêu đề liên hệ</p>
				</div>
			</div>
		</div>

		<div class="flexbox-annotated-section-content">
			<div class="wrapper-content pd-all-20">
				<div class="form-group">
					<label><strong>Thêm mới Speaker Registration VN</strong></label>
					{!! Form::tinyMCE('speaker-registration-vn-created', setting('speaker-registration-vn-created'), ['id' => 'speaker-registration-vn-created', 'class' => 'tinymce']) !!}
				</div>

				<div class="form-group">
					<label><strong>Cập nhật Speaker Registration VN</strong></label>
					{!! Form::tinyMCE('speaker-registration-vn-updated', setting('speaker-registration-vn-updated'), ['id' => 'speaker-registration-vn-updated', 'class' => 'tinymce']) !!}
				</div>

				<div class="form-group">
					<label><strong>Thêm mới Speaker Registration</strong></label>
					{!! Form::tinyMCE('speaker-registration-created', setting('speaker-registration-created'), ['id' => 'speaker-registration-created', 'class' => 'tinymce']) !!}
				</div>

				<div class="form-group">
					<label><strong>Cập nhật Speaker Registration</strong></label>
					{!! Form::tinyMCE('speaker-registration-updated', setting('speaker-registration-updated'), ['id' => 'speaker-registration-updated', 'class' => 'tinymce']) !!}
				</div>

				<div class="form-group">
					<label><strong>Thêm mới Invitee Registration VN</strong></label>
					{!! Form::tinyMCE('invitee-registration-vn-created', setting('invitee-registration-vn-created'), ['id' => 'invitee-registration-vn-created', 'class' => 'tinymce']) !!}
				</div>

				<div class="form-group">
					<label><strong>Cập nhật Invitee Registration VN</strong></label>
					{!! Form::tinyMCE('invitee-registration-vn-updated', setting('invitee-registration-vn-updated'), ['id' => 'invitee-registration-vn-updated', 'class' => 'tinymce']) !!}
				</div>

				<div class="form-group">
					<label><strong>Thêm mới Invitee Registration</strong></label>
					{!! Form::tinyMCE('invitee-registration-created', setting('invitee-registration-created'), ['id' => 'invitee-registration-created', 'class' => 'tinymce']) !!}
				</div>

				<div class="form-group">
					<label><strong>Cập nhật Invitee Registration</strong></label>
					{!! Form::tinyMCE('invitee-registration-updated', setting('invitee-registration-updated'), ['id' => 'invitee-registration-updated', 'class' => 'tinymce']) !!}
				</div>



				<!-- <div class="form-group">					
		<label><strong>Abstract Keynote Response Screen</strong></label>	
		{!! Form::tinyMCE('abstract-keynote', setting('abstract-keynote'), ['id' => 'abstract-keynote', 'class' => 'tinymce'] ) !!}   
	</div>

	<div class="form-group">					
		<label><strong>Abstract Submission Response Screen</strong></label>	
		{!! Form::tinyMCE('abstract-submission', setting('abstract-submission'), ['id' => 'abstract-submission', 'class' => 'tinymce'] ) !!}   
	</div> -->

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

</div>

{!! Form::close() !!}