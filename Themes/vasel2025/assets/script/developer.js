var user_id_check       = false; // 회원가입 중복확인 체크를 위한 변수
var user_repasswd_check = false; // 비밀번호 확인 변수
$(document).ready(function(){
	
	$('.pop_click').on('click',function(){
		var href = $(this).attr('href');
		window.open(href,"pop_click","left=10,top=10,width=800,height=700,resizable=yes,toolbar=no,location=no,status=no,scrollbars=yes");
		return false;
	});
	
	// 텍스트 박스에 앞뒤 공백을 없애준다.
	$("input[type='text']").blur(function(){
		var text = $.trim($(this).val());
		//var make_text = XSS_Check(text,1);
		//$(this).val(make_text);
	});
	
	// datepicker
	jQuery(function(a){a.datepicker.regional.ko={closeText:"닫기",prevText:"이전달",nextText:"다음달",currentText:"오늘",monthNames:["1월","2월","3월","4월","5월","6월","7월","8월","9월","10월","11월","12월"],monthNamesShort:["1월","2월","3월","4월","5월","6월","7월","8월","9월","10월","11월","12월"],dayNames:["일","월","화","수","목","금","토"],dayNamesShort:["일","월","화","수","목","금","토"],dayNamesMin:["일","월","화","수","목","금","토"],weekHeader:"Wk",dateFormat:"yy-mm-dd",firstDay:0,isRTL:false,showMonthAfterYear:false,yearSuffix:"년"};a.datepicker.setDefaults(a.datepicker.regional.ko)});
	$('#sdate, #edate, #date, .date, .sdate, .edate').datepicker({showMonthAfterYear:true, changeMonth: true,	changeYear: true,	dateFormat: "yy-mm-dd", yearRange: 'c-100:c+3'});
	$('.regdate').datepicker({showMonthAfterYear:true, changeMonth: true,	changeYear: true,	dateFormat: "yy-mm-dd", yearRange: 'c-100:c+3', minDate: 0});
	
	$('.timepicker').timepicker({
		timeFormat: 'H:mm',     
		interval: 60,        
		defaultTime: '14',     
		startTime: '00:00',     
		dynamic: false,     
		dropdown: true,     
		scrollbar: true 
	});
	
	//회원가입 아이디 중복확인
	$("#btn_id_check").click(function(){
		
		var id = $("#id").val();
		
		if( id == "" ){
			alert("Please enter your ID(E-mail)");
			user_id_check = false;
			return;
		}else{
			var reg = /([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
			if(!id.match(reg)){
		    	alert("Email address seems incorrect (check @ and .’s)");
				return false;
		    }
		}
		
		$.post( "/member/join/handle/id_check.php", { id : id }, function(data){
			if( data == 1 ){
				alert("This ID is used. Please type in a new ID"); return;
				user_id_check = false;
			}else{
				user_id_check = true;
				$("#id").attr("readonly", true);
				alert("Available to use"); return;
			}
		});

	});
	
	// 회원가입 비밀번호 확인
	$('input[name="passwd"]').on('change', function(){
		var formname = '#'+$(this).parents('form').attr('id');
		if( $(this).hasClass('pass_checked') ){
			/*
			if(!$(this).hasClass('noneID')){
				if( !empty_check('id', '아이디부터 입력 해주세요.', formname) ) return false;
			}
			*/

			function focusPW(msg){
				alert(msg);
				$(formname).find('input[name="passwd"], input[name="repasswd"]').val('');
				$(formname).find('input[name="passwd"]').focus();
			}

			var upw = $(this).val(),
				uid = $(formname).find('input[name="id"]').val();

			if(upw.indexOf(' ') > -1){
				focusPW("비밀번호에 공백이 있습니다.");
				return false;
			}
			
			if(!/^[a-zA-Z0-9!@#$%^&*()_+]{4,}$/.test(upw)) { 
				focusPW("Password must be at least four characters long.");
				return false;
			}
			
			/*
			var chk_num = upw.search(/[0-9]/g); 
			var chk_eng = upw.search(/[a-z]/ig); 

			if(chk_num < 0 || chk_eng < 0){ 
				focusPW("Password must be at least four characters long");
				return false;
			}
			
			if(/(\w)\1\1/.test(upw)){
				focusPW("비밀번호에 같은 문자를 3번 이상 사용하실 수 없습니다.");
				return false;
			}

			if(upw.search(uid)>-1){
				focusPW("ID가 포함된 비밀번호는 사용하실 수 없습니다.");
				return false;
			} 
			*/
		}
	});

	$("#repasswd").keyup(function(){
		if( $("#passwd").val() == $(this).val() ){
			user_repasswd_check = true ;
		}else{
			user_repasswd_check = false ;
		}
	});
	
	$("#none_license").click(function(){
		
		var status = $(this).is(":checked");
		
		if( status ){
			$("#license_number").val("");
			$("#license_number").attr("disabled",true);
		}else{
			$("#license_number").attr("disabled",false);
		}
		
	});
	$("#none_special").click(function(){
		
		var status = $(this).is(":checked");
		
		if( status ){
			$("#specialist_number").val("");
			$("#specialist_number").attr("disabled",true);
		}else{
			$("#specialist_number").attr("disabled",false);
		}
		
	});

	$("#same_id").click(function(){
		
		var status = $(this).is(":checked");
		var email = $("#id").val();
		
		if( status ){
			$("#email1").val(email);
		}else{
			$("#email1").val("");
		}
		
	});

	$(document).on("keyup",'input[name="captcha"]', function(e){//비밀번호 정규 - 엔터키 입력시
		$.ajax({
			type:"POST",
			url:"/member/captcha_ok.php",
			data:{
				'captcha' : $('#captcha').val()
			},
			dataType: 'json',
			async: false,
			success:function(r){
				if(!r._return){
					$("#captcha_ok").val('N');
				}else{
					$("#captcha_ok").val('Y');
				}
			}
		})
	});
	
	$(document).on("blur keyup",".eng_only", function() {
	  var ex = /[^A-Za-z0-9_\`\~\!\@\#\$\%\^\&\*\(\)\-\=\+\\\{\}\[\]\“\”\‘\’\'\"\;\:\<\,\>\.\?\/\s]/gm;
		
		if( ex.test( $(this).val() ) ) {
			alert('Please enter English only');
			$(this).val( $(this).val().replace( ex, '' ) ).focus();
		}
	});

	$( '.email_only' ).on("blur", function() {		
		var email = $(this).val();

		if(email){
			if(!isCorrectEmail($.trim(email))){
				alert('The email format is not valid.');
				$(this).val( "" ).focus();
				return false;
			}
		}
	});
	
	$( '.num_only' ).on("keyup", function() {
	  var ex = /[^0-9\+\-\s]/gm;

		if( ex.test( $(this).val() ) ) {
			alert('Please enter Number only.');
			$(this).val( $(this).val().replace( ex, '' ) ).focus();
		}
	});
	
	$( '.num_only1' ).on("keyup", function() {
	  var ex = /[^0-9\s]/gm;

		if( ex.test( $(this).val() ) ) {
			alert('Please enter Number only.');
			$(this).val( $(this).val().replace( ex, '' ) ).focus();
		}
	});

	$( '.kor_only' ).on("keyup", function() {
		var ex = /[^ㄱ-ㅎ|ㅏ-ㅣ|가-힣|0-9\s]/gm;

		if( ex.test( $(this).val() ) ) {
			alert('한글만 입력해 주세요.');
			$(this).val( $(this).val().replace( ex, '' ) ).focus();
		}
	});

	$( '.kor_only1' ).on("keyup", function() {
		var ex = /[^ㄱ-ㅎ|ㅏ-ㅣ|가-힣\s]/gm;

		if( ex.test( $(this).val() ) ) {
			alert('한글만 입력해 주세요.');
			$(this).val( $(this).val().replace( ex, '' ) ).focus();
		}
	});
	
	$( '.delete_trim' ).on("keyup", function() {
		var text = $(this).val().replace(/ /gi, '');
		$(this).val(text);  
	});
	
	//ADMIN
	$(".admin_check").click(function(){
		
		var status = $(this).is(":checked");
		var sid    = $(this).attr("data");
		
		$.ajax({
		    type: 'POST',
		    url: '/admin/member/handle/admin_check.php',
		    data: { sid : sid, status : status },
		    async: false,
		    success: function(data) {
		    }
		});
		
	});

	$(".regF_check").click(function(){
		
		var status = $(this).is(":checked");
		var sid    = $(this).attr("data");
		
		$.ajax({
		    type: 'POST',
		    url: '/admin/member/handle/reg_check.php',
		    data: { sid : sid, status : status },
		    async: false,
		    success: function(data) {
		    }
		});
		
	});
	

	$(".reviewer_check").click(function(){
		
		var status = $(this).is(":checked");
		var sid    = $(this).attr("data");
		
		$.ajax({
		    type: 'POST',
		    url: '/admin/abstract_review/handle/review_check.php',
		    data: { sid : sid, status : status },
		    async: false,
		    success: function(data) {
		    }
		});
		
	});
	
});

function openDaumPostcode(kind){
	
	new daum.Postcode({
		oncomplete: function(data) {
			if( kind == "member" ){
				$("input:text[name='pcode']").val(data.zonecode);
				$("input:text[name='addr_k']").val(data.address).focus();
				$("input:text[name='addr_e']").val(data.addressEnglish).focus();
			}else if( kind == "office" ){
				$("input:text[name='office_zipcode']").val(data.zonecode);
				$("input:text[name='office_addr']").val(data.address).focus();
			}else if( kind == "home" ){
				$("input:text[name='home_zipcode']").val(data.zonecode);
				$("input:text[name='home_addr']").val(data.address).focus();
			}else{
				
			}
			
			
		}
	}).open();
}

function XSS_Check(strTemp, level) {
	if ( level == undefined || level == 0 ){
		strTemp = strTemp.replace(/\<|\>|\"|\'|\%|\;|\(|\)|\&|\+|\-/g,"");		
	}else if (level != undefined && level == 1 ){
	    strTemp = strTemp.replace(/\</g, "&lt;");
	    strTemp = strTemp.replace(/\>/g, "&gt;");
	}
    return strTemp;
}

function select_etc(target,val){
	
	if(target == 'gubun'){
		
		$('#license_number').val('').attr('disabled',true);
		$('#none_license').prop('checked',false);
		$('#specialist_number').val('').attr('disabled',true);
		$('#none_special').prop('checked',false);
		$("#"+target+"_etc").val("");
		$("#"+target+"_etc").attr("disabled",true);

		if( val == "1" ){
			$('#license_number').val('').attr('disabled',false);
			$('#none_license').prop('checked',false);
			$('#specialist_number').val('').attr('disabled',false);
			$('#none_special').prop('checked',false);
		}else if( val == "2" || val == "3" || val == "6" ){
			$('#none_special').prop('checked',true);
			$('#license_number').val('').attr('disabled',false);
		}else{
			$('#license_number').val('').attr('disabled',true);
			$('#none_license').prop('checked',true);
			$('#specialist_number').val('').attr('disabled',true);
			$('#none_special').prop('checked',true);
			if( val == "999" ){
				$("#"+target+"_etc").attr("disabled",false);
			}
		}

	}else{

		if( val == "999" ){
			$("#"+target+"_etc").attr("disabled",false);
		}else{
			$("#"+target+"_etc").val("");
			$("#"+target+"_etc").attr("disabled",true);
		}

	}
	
}

// 로그인 유효성 검사
function login_check(f){
	if( $(f.id).val() == "" ){
		alert("Please enter ID(E-mail)");
		$(f.id).focus();
		return false;
	}
	if( $(f.passwd).val() == "" ){
		alert("The password you entered is incorrect. Please try again.");
		$(f.passwd).focus();
		return false;
	}
	return true;
}

function change_affiliation(){
	
	var value = $("#affiliation").val();
	
	if( value != "" ){
		$.ajax({
		    type: 'POST',
		    url: '/member/join/handle/ajax_affiliation.php',
		    data: { value : value },
		    async: false,
		    success: function(data) {
		    	data = JSON.parse(data);
		    	if( data.office_k == "기타" ){
		    		$("#affiliation_k").val("").attr('readonly', false);
			    	$("#affiliation_e").val("").attr('readonly', false);
			    	$("#pcode").val("");
			    	$("#addr_k").val("").attr('readonly', false);
			    	$("#addr_e").val("").attr('readonly', false);
		    	}else{
		    		$("#affiliation_k").val(data.office_k).attr('readonly', true);
			    	$("#affiliation_e").val(data.office_e).attr('readonly', true);
			    	$("#pcode").val(data.new_post);
			    	$("#addr_k").val(data.addr_k).attr('readonly', true);
			    	$("#addr_e").val(data.addr_e).attr('readonly', true);
		    	}
		    }
		});
	}
	
}

function change_department(){
	
	var value = $("#department").val();
	var kname = $("#department").find("option:selected").attr('kname');
	var ename = $("#department").find("option:selected").attr('ename');	
	
	if( value != "" ){
		if( value == "999" ){
			$("#department_k").val("").attr('readonly', false);
			$("#department_e").val("").attr('readonly', false);
		}else{
			$("#department_k").val(kname).attr('readonly', true);
			$("#department_e").val(ename).attr('readonly', true);
		}
	}
	
}

function change_country(){
	
	var value = $("#ccode").val();
	
	if( value != "" ){
		$.ajax({
		    type: 'POST',
		    url: '/member/join/handle/ajax_country.php',
		    data: { value : value },
		    async: false,
		    success: function(data) {
		    	$(".front_num").val(data);
		    }
		});
	}
	
}

function signup_check(f){
	
	var lang = $(f.lang).val();
	var sid  = $(f.sid).val();
	var admin_yn  = $(f.admin_yn).val();
	var captcha_ok = $("#captcha_ok").val();

	/*
	if(lang == "ENG"){
		if( sid == "" ){		
			if( $("input:radio[name='agree']").is(":checked") == false ){
				alert("Please agree to the privacy terms.");
				$("input:radio[name='agree']").focus();
				return false;
			}
			if( $(f.ccode).val() == "" ){
				alert("Please select a country.");
				$(f.ccode).focus();
				return false;
			}
			if( $(f.id).val() == "" ){
				alert("Please enter your ID.");
				$(f.id).focus();
				return false;
			}
			if( !user_id_check ){
				alert("Please verify your username duplicate.");
				$(f.id).focus();
				return false;
			}
			if( $(f.passwd).val() == "" ){
				alert("Please enter your Password.");
				$(f.passwd).focus();
				return false;
			}
			if( $(f.repasswd).val() == "" ){
				alert("Please enter password confirmation.");
				$(f.repasswd).focus();
				return false;
			}
			if( !user_repasswd_check ){
				alert("Passwords do not match.");
				$(f.repasswd).focus();
				return false;
			}
			
		}else{
			
			if( $(f.passwd).val() != "" && $(f.repasswd).val() == "" ){
				alert("Please enter password confirmation.");
				$(f.repasswd).focus();
				return false;
			}
			if( $(f.passwd).val() != "" && !user_repasswd_check ){
				alert("Passwords do not match.");
				$(f.repasswd).focus();
				return false;
			}
			
		}

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
		if( $("input:radio[name='title']").is(":checked") == false ){
			alert("Please select a title.");
			$("input:radio[name='title']").eq(0).focus();
			return false;
		}
		if( $("input:radio[name='title']:checked").val() == "999" ){
			if( $(f.title_etc).val() == "" ){
				alert("Please enter other information.");
				$(f.title_etc).focus();
				return false;
			}
		}

		if( $("input:radio[name='degree']").is(":checked") == false ){
			alert("Please select a Degree.");
			$("input:radio[name='degree']").eq(0).focus();
			return false;
		}
		if( $("input:radio[name='degree']:checked").val() == "999" ){
			if( $(f.degree_etc).val() == "" ){
				alert("Please enter other information.");
				$(f.degree_etc).focus();
				return false;
			}
		}
		if( $(f.affiliation_e).val() == "" ){
			alert("Please enter your Institution/Organization.");
			$(f.affiliation_e).focus();
			return false;
		}
		if( $(f.department_e).val() == ""  ){
			alert("Please enter your department");
			$(f.department_e).focus();
			return false;
		}

		if( $(f.addr_e).val() == "" ){
			alert("Please enter an Address.");
			$(f.addr_e).focus();
			return false;
		}
		
		if( $(f.pcode).val() == "" ){
			alert("Please enter your Postal Code.");
			$(f.pcode).focus();
			return false;
		}
		
		if( $(f.city).val() == "" ){
			alert("Please enter your City.");
			$(f.city).focus();
			return false;
		}
		if( $("#mobile_1").val() == "" || $("#mobile_2").val() == "" ){
			alert("Please enter your mobile phone number.");
			$("#mobile_1").focus();
			return false;
		}

		if( $("#tel_2").val() == "" || $("#tel_3").val() == "" ){
			alert("Please enter your mobile telephone number.");
			$("#tel_2").focus();
			return false;
		}

		if( $(f.email1).val() == ""  ){
			alert("Please enter your E-mail 1");
			$(f.email1).focus();
			return false;
		}
		
	}else if( lang == "KOR" ){
		if( sid == "" ){		
			if( $("input:radio[name='agree']").is(":checked") == false ){
				alert("Please agree to the privacy terms.");
				$("input:radio[name='agree']").focus();
				return false;
			}
			if( $(f.id).val() == "" ){
				alert("Please enter your ID.");
				$(f.id).focus();
				return false;
			}
			if( !user_id_check ){
				alert("Please verify your username duplicate.");
				$(f.id).focus();
				return false;
			}
			if( $(f.passwd).val() == "" ){
				alert("Please enter your 비밀번호.");
				$(f.passwd).focus();
				return false;
			}
			if( $(f.repasswd).val() == "" ){
				alert("Please enter 비밀번호 confirmation.");
				$(f.repasswd).focus();
				return false;
			}
			if( !user_repasswd_check ){
				alert("비밀번호 do not match.");
				$(f.repasswd).focus();
				return false;
			}
			
		}else{
			
			if( $(f.passwd).val() != "" && $(f.repasswd).val() == "" ){
				alert("Please enter 비밀번호 confirmation.");
				$(f.repasswd).focus();
				return false;
			}
			if( $(f.passwd).val() != "" && !user_repasswd_check ){
				alert("비밀번호 do not match.");
				$(f.repasswd).focus();
				return false;
			}
			
		}
		if( $(f.name_kr).val() == "" ){
			alert("Please enter your 성명(국문).");
			$(f.name_kr).focus();
			return false;
		}
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
		if( $("input:radio[name='gubun']").is(":checked") == false ){
			alert("Please select 의사구분.");
			$("input:radio[name='gubun']").eq(0).focus();
			return false;
		}

		if( $("input:checkbox[name='none_license']").is(":checked") == false ){
			if( $(f.license_number).val() == "" && lang == "KOR" ){
				alert("Please enter your 의사면허번호.");
				$(f.license_number).focus();
				return false;
			}
		}
		if( $("input:checkbox[name='none_special']").is(":checked") == false ){
			if( $(f.specialist_number).val() == "" && lang == "KOR" ){
				alert("Please enter your 전문의번호.");
				$(f.specialist_number).focus();
				return false;
			}
		}

		if( $("input:radio[name='title']").is(":checked") == false ){
			alert("Please select a title.");
			$("input:radio[name='title']").eq(0).focus();
			return false;
		}
		if( $("input:radio[name='title']:checked").val() == "999" ){
			if( $(f.title_etc).val() == "" ){
				alert("Please enter other information.");
				$(f.title_etc).focus();
				return false;
			}
		}

		if( $("input:radio[name='degree']").is(":checked") == false ){
			alert("Please select a Degree.");
			$("input:radio[name='degree']").eq(0).focus();
			return false;
		}
		if( $("input:radio[name='degree']:checked").val() == "999" ){
			if( $(f.degree_etc).val() == "" ){
				alert("Please enter other information.");
				$(f.degree_etc).focus();
				return false;
			}
		}

	}
	*/
	

	if(admin_yn != 'Y'){

	
		if( sid == "" ){
			
			if( $("input:radio[name='agree']").is(":checked") == false ){
				alert("Please agree to the privacy terms.");
				$("input:radio[name='agree']").focus();
				return false;
			}
			if( $(f.ccode).val() == "" && lang == "ENG" ){
				alert("Please select a country.");
				$(f.ccode).focus();
				return false;
			}
			if( $(f.id).val() == "" ){
				alert("Please enter your ID.");
				$(f.id).focus();
				return false;
			}
			if( !user_id_check ){
				alert("Please verify your ID duplicate.");
				$(f.id).focus();
				return false;
			}
			if( $(f.passwd).val() == "" ){
				alert("Please enter your Password.");
				$(f.passwd).focus();
				return false;
			}
			if( $(f.repasswd).val() == "" ){
				alert("Please enter password confirmation.");
				$(f.repasswd).focus();
				return false;
			}
			if( !user_repasswd_check ){
				alert("Passwords do not match.");
				$(f.repasswd).focus();
				return false;
			}
			
		}else{
			
			if( $(f.old_passwd).val() == "" ){
				alert("Please enter a password.");
				$(f.old_passwd).focus();
				return false;
			}
			if( $(f.passwd).val() != "" && $(f.repasswd).val() == "" ){
				alert("Please enter New password confirmation.");
				$(f.repasswd).focus();
				return false;
			}
			if( $(f.passwd).val() != "" && !user_repasswd_check ){
				alert("New Passwords do not match.");
				$(f.repasswd).focus();
				return false;
			}
			
		}
		
		
		
		if( $(f.name_kr).val() == "" && lang == "KOR" ){
			alert("Please enter your Korean name.");
			$(f.name_kr).focus();
			return false;
		}
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
		
		if( $("input:radio[name='gubun']").is(":checked") == false && lang == "KOR" ){
			alert("Please select a category.");
			$("input:radio[name='gubun']").eq(0).focus();
			return false;
		}
		if( $("input:radio[name='gubun']:checked").val() == "999" && lang == "KOR" ){
			if( $(f.gubun_etc).val() == "" ){
				alert("Please enter other information.");
				$(f.gubun_etc).focus();
				return false;
			}
		}

		if( $("input:checkbox[name='none_license']").is(":checked") == false && lang == "KOR" ){
			if( $(f.license_number).val() == "" && lang == "KOR" ){
				alert("Please enter your License Number");
				$(f.license_number).focus();
				return false;
			}
		}
		if( $("input:checkbox[name='none_special']").is(":checked") == false && lang == "KOR" ){
			if( $(f.specialist_number).val() == "" && lang == "KOR" ){
				alert("Please enter your Specialist Number");
				$(f.specialist_number).focus();
				return false;
			}
		}
		
		if( $("input:radio[name='registration']").is(":checked") == false && lang == "ENG" ){
			alert("Please select a Registration.");
			$("input:radio[name='registration']").eq(0).focus();
			return false;
		}
		if( $("input:radio[name='registration']:checked").val() == "999" && lang == "ENG" ){
			if( $(f.registration_etc).val() == "" ){
				alert("Please enter other information.");
				$(f.registration_etc).focus();
				return false;
			}
		}

		if( $("input:radio[name='title']").is(":checked") == false ){
			alert("Please select a title.");
			$("input:radio[name='title']").eq(0).focus();
			return false;
		}
		if( $("input:radio[name='title']:checked").val() == "999" ){
			if( $(f.title_etc).val() == "" ){
				alert("Please enter other information.");
				$(f.title_etc).focus();
				return false;
			}
		}

		if( $("input:radio[name='degree']").is(":checked") == false ){
			alert("Please select a Degree.");
			$("input:radio[name='degree']").eq(0).focus();
			return false;
		}
		if( $("input:radio[name='degree']:checked").val() == "999" ){
			if( $(f.degree_etc).val() == "" ){
				alert("Please enter other information.");
				$(f.degree_etc).focus();
				return false;
			}
		}
		
		if( lang == "KOR" ){
			if( $(f.department).val() == "" && lang == "KOR" ){
				alert("Please select department.");
				$(f.department).focus();
				return false;
			}
			if( $(f.department_k).val() == "" && lang == "KOR" ){
				alert("Please enter your department name.");
				$(f.department_k).focus();
				return false;
			}
			if( $(f.department_e).val() == "" && lang == "KOR" ){
				alert("Please enter your department English name.");
				$(f.department_e).focus();
				return false;
			}
		}else{
			if( $("input:radio[name='department']").is(":checked") == false && lang == "ENG" ){
				alert("Please select a department.");
				$("input:radio[name='department']").focus();
				return false;
			}
			if( $("input:radio[name='department']:checked").val() == "999" && lang == "ENG" ){
				if( $(f.department_etc).val() == "" && lang == "ENG" ){
					alert("Please enter your department Others name.");
					$(f.department_etc).focus();
					return false;
				}
			}
		}
		
		
		if( $(f.affiliation).val() == "" && lang == "KOR" ){
			alert("Please select affiliation.");
			$(f.affiliation).focus();
			return false;
		}
		if( $(f.affiliation_k).val() == "" && lang == "KOR" ){
			alert("Please enter your affiliation name.");
			$(f.affiliation_k).focus();
			return false;	
		}
		if( $(f.affiliation_e).val() == "" && lang == "KOR" ){
			alert("Please enter your affiliation English name.");
			$(f.affiliation_e).focus();
			return false;
		}	
		
		if( $(f.affiliation_e).val() == "" && lang == "ENG" ){
			alert("Please enter your Institution/Organization.");
			$(f.affiliation_e).focus();
			return false;
		}

		if( lang == "KOR" ){
			if($(f.affiliation).val() != "76"){
				if( $(f.pcode).val() == "" && lang == "KOR" ){
					alert("Please enter your Postal Code");
					$(f.pcode).focus();
					return false;
				}
				if( $(f.addr_k).val() == "" && lang == "KOR" ){
					alert("Please enter your address.");
					$(f.addr_k).focus();
					return false;
				}
				if( $(f.addr_e).val() == "" ){
					alert("Please enter an English address.");
					$(f.addr_e).focus();
					return false;
				}
			}
		}
	/*
		if( $(f.department_k).val() == "" && lang == "KOR" ){
			alert("Please enter your department name.");
			$(f.department_k).focus();
			return false;
		}
		if( $(f.department_e).val() == ""  ){
			alert("Please enter your department");
			$(f.department_e).focus();
			return false;
		}
	*/
		if( $(f.addr_e).val() == "" && lang == "ENG" ){
			alert("Please enter an Address.");
			$(f.addr_e).focus();
			return false;
		}
		
		if( $(f.pcode).val() == "" && lang == "ENG" ){
			alert("Please enter your Postal Code.");
			$(f.pcode).focus();
			return false;
		}
		
		if( $(f.city).val() == "" && lang == "ENG" ){
			alert("Please enter your City.");
			$(f.city).focus();
			return false;
		}


		if( $("#mobile_1").val() == "" || $("#mobile_2").val() == "" ){
			alert("Please enter your mobile phone number.");
			$("#mobile_1").focus();
			return false;
		}
		
		/*
		if( $("#tel_2").val() == "" || $("#tel_3").val() == "" ){
			alert("Please enter your mobile telephone number.");
			$("#tel_2").focus();
			return false;
		}
		*/

		if( $(f.email1).val() == ""  ){
			alert("Please enter your E-mail 1");
			$(f.email1).focus();
			return false;
		}
		if( $("input:checkbox[name='email1_receive']").is(":checked") == false ){
			alert("Please check the e-mail.");
			$("input:checkbox[name='email1_receive']").focus();
			return false;
		}

		if( $("input:radio[name='request']").is(":checked") == false ){
			alert("Please select a Special Request for Food.");
			$("input:radio[name='request']").eq(0).focus();
			return false;
		}

	}

	if(captcha_ok != 'Y'){
		alert('Your response to the CAPTCHA appears to be invalid. Please re-verify that you\'re not a robot.');
		return false;
	}
	
	return true;
	
}

function check_find(f){
	
	if( $(f.email).val() == "" ){
		alert("Please enter your ID.");
		return false;
	}
	
}

//첫 문자를 대문자로 First Name
function toFirstOpper(id){
	
	var orgStr = $('#'+id).val();

	//무조건 소문자 변환 후 첫글자 대문자 처리
	orgStr = orgStr.toLowerCase();
	$('#'+id).val(orgStr);

	if(orgStr != ''){

		var result = '';
		var result2 = '';
		var objStr = new Object();
		var objStr2 = new Object();
		var delim = ' ';

		objStr = orgStr.split(delim);

		for( var i=0; i < objStr.length; i++) {
			objStr[i] = objStr[i].substr(0,1).toUpperCase() + objStr[i].substr(1,objStr[i].length);
			result = result + objStr[i]+" ";
		}

		//alert(result);return false;
		result = $.trim(result);
		//First Name의 - 기호 구분시 첫 문자를 대문자로 치환
		delim = '-';
		objStr2 = result.split(delim);

		for( var i=0; i < objStr2.length; i++) {
			objStr2[i] = objStr2[i].substr(0,1).toUpperCase() + objStr2[i].substr(1,objStr2[i].length);
			result2 = result2 + objStr2[i];
			if (i < objStr2.length-1) result2 = result2 + "-";
		}

		result2 = $.trim(result2);
		$('#'+id).val(result2);
	}
	return result2;

}

//첫 문자를 대문자로 First Name
function toFirstOpper2(f){

	var orgStr = $(f).val();
	
	//무조건 소문자 변환 후 첫글자 대문자 처리
	orgStr = orgStr.toLowerCase();
	$(f).val(orgStr);

	if(orgStr != ''){

		var result = '';
		var result2 = '';
		var objStr = new Object();
		var objStr2 = new Object();
		var delim = ' ';

		objStr = orgStr.split(delim);

		for( var i=0; i < objStr.length; i++) {
			objStr[i] = objStr[i].substr(0,1).toUpperCase() + objStr[i].substr(1,objStr[i].length);
			result = result + objStr[i]+" ";
		}

		//alert(result);return false;
		result = $.trim(result);
		//First Name의 - 기호 구분시 첫 문자를 대문자로 치환
		delim = '-';
		objStr2 = result.split(delim);

		for( var i=0; i < objStr2.length; i++) {
			objStr2[i] = objStr2[i].substr(0,1).toUpperCase() + objStr2[i].substr(1,objStr2[i].length);
			result2 = result2 + objStr2[i];
			if (i < objStr2.length-1) result2 = result2 + "-";
		}

		result2 = $.trim(result2);
		$(f).val(result2);
	}
	return result2;

}

function toOneOpper(id){
	var orgStr = $('#'+id).val();
	if(orgStr != ''){
		
		var result = orgStr.substring(0,1).toUpperCase() + orgStr.substring(1);
		
		$('#'+id).val(result);
	}
}

function toOneOpper2(f){
	var orgStr = $(f).val();
	if(orgStr != ''){
		var result = orgStr.substring(0,1).toUpperCase() + orgStr.substring(1);
		$(f).val(result);
	}
}

function toAllOpper(f){
	var orgStr = $(f).val();
	if(orgStr != ''){
		var result = orgStr.toUpperCase();
		$(f).val(result);
	}
}

function han_check(val){
	var ex = /[^A-Za-z0-9_\`\~\!\@\#\$\%\^\&\*\(\)\-\=\+\\\{\}\[\]\'\"\;\:\<\,\>\.\|\?\/。〈〉《》±×÷≠≤≥∞℃Å≒∑αβγδεζηθικλμνξοπρστυφχψωΩ㎕㎖㎗ℓ㎘㏄㎣㎤㎥㎦㎙㎚㎛㎜㎝㎞㎟㎠㎡㎢㏊㎍㎎㎏㏏㎈㎉㏈㎧㎨㎰㎱㎲㎳㎴㎵㎶㎷㎸㎹㎀㎁㎂㎃㎄㎺㎻㎼㎽㎾㎿㎐㎑㎒㎓㎔Ω㏀㏁㎊㎋㎌㏖％¹²³⁴₁₂₃₄†‡§¶\s]/gm;
	if( ex.test( val ) ) return true;
}

function isCorrectEmail(email) {
	if(!email) return false;
	return /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i.test(email);
}

function comma(str) {
    var parts=str.toString().split(".");
    return parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",") + (parts[1] ? "." + parts[1] : "");
}


//파일체크
function getThumbnailPrivew(html,target) {
	
	var image_type = html.files[0]['type'];
	var image_size = Math.floor(html.files[0]['size']/1024);
	var extension  = html.files[0]['name'].split('.');
	var extension_re  = extension.reverse()[0];
	var denyfile = "jpeg,JPEG,jpg,JPG,gif,GIF,png,PNG,pptx,PPTX,ppt,PPT,pdf,PDF,doc,DOC,docx,DOCX,xlsx,XLSX,xlsm,XLSM,xlsd,XLSD,xltx,XLTX,xls,XLS,xlt,XLT,xml,XML,xlam,XLAM,text,TEXT,txt,TXT,hwp,HWP"; 
	
	if( target == "a_file1" || target == "a_file2" || target == "a_file4" ){
		if( extension_re != "jpg" && extension_re != "JPG" && extension_re != "PNG" && extension_re != "png" && extension_re != "gif" && extension_re != "GIF" && extension_re != "hwp" && extension_re != "HWP" && extension_re != "docx" && extension_re != "DOCX" && extension_re != "doc" && extension_re != "DOC" ){
			alert("Figures : Only JPG, GIF, PNG, DOC, DOCX and HWP files can be uploaded.");
			$("#"+target).val("");
			$("#"+target+"_name").val("");
			return;
		}
	}else if( target == "a_file3" ){
		if( extension_re != "jpg" && extension_re != "JPG" && extension_re != "PNG" && extension_re != "png" && extension_re != "gif" && extension_re != "GIF" ){
			alert("Document for proof of age : Only JPG, GIF, PNG and hwp files can be uploaded.");
			$("#"+target).val("");
			$("#"+target+"_name").val("");
			return;
		}
	}else if( target == "cv_file" ){
		if( extension_re != "doc" && extension_re != "DOC" && extension_re != "docx" && extension_re != "DOCX" && extension_re != "pdf" && extension_re != "PDF" ){
			alert("Only doc, docx and pdf files can be uploaded.");
			$("#"+target).val("");
			$("#"+target+"_name").val("");
			return;
		}
	}else if( target == "userfile" ){
		if( extension_re != "ppt" && extension_re != "PPT" && extension_re != "pptx" && extension_re != "PPTX" ){
			alert("Only ppt, pptx files can be uploaded.");
			$("#"+target).val("");
			return;
		}
	}else if( target == "a_file1_reg" || target == "a_file2_reg" || target == "a_file3_reg" ){
		if( extension_re != "jpg" && extension_re != "JPG" && extension_re != "PNG" && extension_re != "png" && extension_re != "gif" && extension_re != "GIF" && extension_re != "pdf" && extension_re != "PDF" ){
			alert("Only JPG, GIF, PNG, PDF files can be uploaded.");
			if(target == "a_file1_reg"){
				target2 = 'a_file1';
			}else if(target == "a_file2_reg"){
				target2 = 'a_file2';
			}else if(target == "a_file3_reg"){
				target2 = 'a_file3';
			}
			$("#"+target2).val("");
			$("#"+target2+"_name").val("");
			return;
		}
	}
		
}

function file_check(file,name){
	if( file && $("#"+name).is(":checked") == false ){
		alert("이미 첨부되어있는 파일이 있습니다. 삭제 체크 후 변경해주세요.");
		return false;
	}else{
		return true;
	}
}

function DB_chage(rtext, targetCU, targetVAL, _sid, posturl, carr, targetTBL){
	var return_TF = true;
	
	$.ajax({
		type: 'post',
		dataType: 'json',
		url: posturl,
		async: false,
		data: {
		'targetCU' : targetCU,
		'targetVAL' : targetVAL,
		'chk_arr' : carr,
		'chkval' : _sid,
		'targetTBL' : targetTBL,
		}
	}).done(function( r ) {
		if(!r._return){
			alert(r.msg);
			return_TF = false;
		}else{
			if($.trim(rtext)){
				alert(rtext);
			}
		}
	});

	return return_TF;
}

function phoneFormat(target) {
  // 특수문자 제거
  target.value = target.value.replace(/[^0-9]/g, "");

  const value = target.value.split("");

  if(value.length >= 10){
	  const textArr = [
		// 첫번째 구간 (00 or 000)
		[0, value.length > 9 ? 3 : 2],
		// 두번째 구간 (000 or 0000)
		[0, value.length > 10 ? 4 : 3],
		// 남은 마지막 모든 숫자
		[0, 4]
	  ];

	  // 총 3번의 반복 ({2,3}) - ({3,4}) - ({4})
	  target.value = textArr
		.map(function(v)  { 
		  return value.splice(v[0], v[1]).join("") 
		})
		.filter(function(text) { 
		  return text 
		})
		.join("-");
  }
}

function refresh_captcha(){
	const now = new Date();	// 현재 날짜 및 시간
	const hour = now.getHours();
	const minutes = now.getMinutes();
	const seconds = now.getSeconds();
	document.getElementById("captcha_img").src="/func/captcha.php?date="+hour+":"+minutes+":"+seconds; 
}


function readURL(input,checked,carr,text,check_text,eximg) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();
		var check = file_check(input,checked,carr,text,check_text);
		if(check){
			reader.onload = function (e) {
				$('#'+eximg).attr('src', e.target.result);
			}
			reader.readAsDataURL(input.files[0]);
		}
	}
}

//파일 체크
function file_check(fname,checked,carr,text,check_text){
	isCheck = false;
	filename = fname.value;
	var file_gubun_arr = filename.split('.');
	var file_arr_len = file_gubun_arr.length;
	var file_gubun = file_gubun_arr[file_arr_len-1];
	var checkarr = carr.split('|');

	if(checked){
		if (in_array(checkarr,file_gubun)){
			isCheck = true;
		}
	}else{
		isCheck = true;
	}

	if(filename){
		if (isCheck == false){
			if(check_text){
				alert(check_text);
			}else{
				alert("You can only upload a file with the extension "+text+".");
			}
			fname.select();
			fname.value="";
			return false;
		}else{
			return true;
		}
	}
	return false;

}

function reset_file(input,target,viewiD) {
	input.select();
	input.value="";
	$('#'+target).val('');
	if(viewiD){
		$('#'+viewiD).prop('src', $('#'+viewiD).attr('old_src'));
	}
	return false;
}

function in_array(arr, obj) {
	for(var i = 0, len = arr.length; i < len; i++) {
		if(arr[i] == obj) {
			return true;
		} 
	}
	return false;
};

function dateFormat(target){
	// 특수문자 제거
	//var ex = /[^0-9\+\-\s]/gm;
	var ex = /[^0-9]/gm;
	target.value = target.value.replace(ex, "");

	const value = target.value.split("");

	if(value.length >= 4){
		const textArr = [
			[0, 4],
			[0, 2],
			[0, 2]
		];

		target.value = textArr
		.map(function(v)  { 
			return value.splice(v[0], v[1]).join("") 
		})
		.filter(function(text) { 
			return text 
		})
		.join("-");
	}
}

function isCorrectdate(date) {
	if(!date) return false;
	datatimeRegexp = /[0-9]{4}-[0-9]{2}-[0-9]{2}/;
	return datatimeRegexp.test(date);
}

function viewer_area(kind,str){

	if(kind!='sponsors') $('.sponsors_Area').hide();
	if(kind!='main_popup01') $('.main_popup01_Area').hide();
	if(kind!='program_session') $('.program_session_Area').hide();

	$(".sponsors_Area").html("");

	if(kind=='sponsors'){
		if($('.sponsors_Area').is(':visible')==false){
			$(".sponsors_Area").load("/sponsor/form/layer_"+str+".php", function(response, status, xhr){
				if(status=='success'){
					$('.sponsors_Area').fadeIn();
				}
			});	
		}else{
			$('.sponsors_Area').fadeOut();
		}
	}else if(kind=='main_popup01'){
		if($('.main_popup01_Area').is(':visible')==false){
			$('.main_popup01_Area').fadeIn();
		}else{
			$('.main_popup01_Area').fadeOut();
		}
	}else if(kind=='program_session'){
		if($('.program_session_Area').is(':visible')==false){
			$.ajax({
				type:"GET",
				url:"/program/layer_popup_session.php",
				data:{
					'sid':str,
				},
				dataType : "html",
				async: true,
				success:function(data){
					$('.program_session_Area').html(data).fadeIn();
				}
			});
		}else{
			$('.program_session_Area').fadeOut();
			$(".program_session_Area").html("");
		}
	}
}

function radioOneClick(target,thisID,values){
	if(values){
		$('.'+target+'[value="'+values+'"]').not('#'+thisID).prop({"checked": false});
	}else{
		$('.'+target).not('#'+thisID).prop({"checked": false});
	}
}