<script>
	jQuery(document).ready(function () {
		let form = document.querySelector('<?php echo $validator['selector']; ?>');
		let spinner = document.querySelector('#spinner');
		let registration_button = document.querySelector('#registration_button');

		$("<?php echo $validator['selector']; ?>").validate({
			highlight: function (element) { // hightlight error inputs
				$(element)
					.closest('.form-group').addClass('has-error'); // set error class to the control group
			},
			unhighlight: function (element) { // revert the change done by hightlight
				$(element)
					.closest('.form-group').removeClass('has-error'); // set error class to the control group
			},
			errorElement: 'span', //default input error message container
			errorClass: 'help-block error-help-block', // default input error message class
			focusInvalid: true, // do not focus the last invalid input
			ignore: ":hidden:not(#shortCV_input, #passport_input)",  // validate all fields including form hidden input
			errorPlacement: function (error, element) {
				if (element.attr('type') == 'radio' || element.attr('type') == 'checkbox') {
					error.appendTo(element.closest('.form-group'));
				} else {
					error.insertAfter(element);
				}
			},
			success: function (label) {
				label
					.closest('.form-group').removeClass('has-error'); // set success class to the control group


			},
			rules: <?php echo json_encode($validator['rules']); ?>
		})

		jQuery.validator.setDefaults({
			debug: true,
			success: "valid"
		});

		form.addEventListener('submit', (e) => {
			const shortCVInput = document.querySelector('#shortCV_input');
			const passportInput = document.querySelector('#passport_input');
			const hasShortCV = $('#shortCV_name').data('exists') == 1;
			const hasPassport = $('#passport_name').data('exists') == 1;

			const hasShortCVNew = shortCVInput.files.length > 0;
			const hasPassportNew = passportInput.files.length > 0;

			console.log({ hasShortCVNew });


			if (!hasShortCV && !hasShortCVNew) {
				e.preventDefault();
				alert('Please select your CV file');
				return;
			}

			if (!hasPassport && !hasPassportNew) {
				e.preventDefault();
				alert('Please select your Passport file');
				return;
			}
			if ($(form).valid()) {
				spinner.style.display = 'inline-block';
				registration_button.disabled = true
				setTimeout(function () {
					registration_button.disabled = false
					spinner.style.display = 'none';
				}, 5000);
			}
		})
	})
</script>