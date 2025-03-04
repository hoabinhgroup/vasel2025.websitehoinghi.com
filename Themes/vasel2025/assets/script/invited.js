$(function(){
	$(document).on("click", '.DB_click', function() {
		var _sid = $(this).attr('sid'),
			dbname = $(this).attr('dbname'),
			value = $(this).attr('DBvalue'),
			title = $(this).attr('title'),
			wreload = $(this).attr('wreload'),
			dbtbl = $(this).attr('DBtbl'),
			rconfirm = $(this).attr('confirm');

		if($.trim(rconfirm) && !confirm(rconfirm)){
			return false;
		}

		var DBreturn = DB_chage(title, dbname, value, _sid, '/invited/DB_change.php');		
		
		if(dbtbl=='favor'){
			if(wreload=='true'){
				location.reload();
			}else{
				$('#reload_box'+_sid).load(location.href+' #reload_target'+_sid);
			}
		}else{
			if(wreload=='true'){
				location.reload();
			}
		}
		return false;
	});
});