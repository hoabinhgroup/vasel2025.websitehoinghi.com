$(document).ready(function(){
	
	$('#email_chk').click(function(){
		var formname = "#reg_form01";
		if($(formname).length==0){
			formname = "#reg_form01";
		}

		if( $('#email').val() == "" ){
			alert("Please enter E-mail");
			$('#email').focus();
			return false;
		}
		
		var $idObj = $(formname).find('input[name="email"]');

		var email = $idObj.val();
		var number = $("#number").val();		

		if(!isCorrectEmail($.trim(email))){
			alert('This is not a valid format.');
			$(formname).find('input[name="email"]').focus();
			return false;
		}

		$.ajax({
			type:"POST",
			url:"/mailing/handle/email_chk.php",
			data:{
				'email' : email,
				'number' : number
			},
			dataType: 'json',
			async: false,
			success:function(r){
				if(!r._return){
					alert(r.msg);
					$(formname).find('input[name="check_email"]').val('N');
					$idObj.val('').focus();
				}else{
					alert(r.msg);
					$(formname).find('input[name="check_email"]').val('Y');
				}
			}
		});
		return false;
	});

	$('#email').on("change keyup paste", function(){
		var formname = "#reg_form01";
		if($(formname).length==0){
			formname = "#reg_form01";
		}
		$(formname).find('input[name="check_email"]').val('N');
	});
	
});

function mailing_check(f){
	var captcha_ok = $("#captcha_ok").val();

	if( $(f.first_name).val() == "" ){
		alert("Please enter your First Name.");
		$(f.first_name).focus();
		return false;
	}
	if( $(f.last_name).val() == "" ){
		alert("Please enter your Last Name.");
		$(f.last_name).focus();
		return false;
	}
	if( $(f.ccode).val() == "" ){
		alert("Please select a country.");
		$(f.ccode).focus();
		return false;
	}
	if( $(f.email).val() == "" ){
		alert("Please enter your E-mail.");
		$(f.email).focus();
		return false;
	}
	if( $(f.check_email).val() != "Y" ){
		alert("Please verify your E-mail duplicate.");
		$(f.email).focus();
		return false;
	}
	if( $("input:radio[name='congress']").is(":checked") == false ){
		alert("Please select a congress.");
		$("input:radio[name='congress']").eq(0).focus();
		return false;
	}
	if( $("input:radio[name='abstract']").is(":checked") == false ){
		alert("Please select an abstract.");
		$("input:radio[name='abstract']").eq(0).focus();
		return false;
	}
	if( $("input:radio[name='opport']").is(":checked") == false  ){
		alert("Please select an opportunities.");
		$("input:radio[name='opport']").eq(0).focus();
		return false;
	}

	if(captcha_ok != 'Y'){
		alert('Your response to the CAPTCHA appears to be invalid. Please re-verify that you\'re not a robot.');
		return false;
	}

}

function mailing_cancel(){
	if(confirm('Are you sure you want to unregister?')){
		location.href='/';
	}else{
		return false;
	}
}