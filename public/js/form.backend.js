/*$(function() {   
	$.validator.addMethod("valueNotEquals", function(value, element, arg){
   console.log(element.value);
    return 0 != element.value; 
}, "Value must not equal arg.");

var getUrlParameter = function getUrlParameter(sParam) {
			var sPageURL = decodeURIComponent(window.location.search.substring(1)),
				sURLVariables = sPageURL.split('&'),
				sParameterName, i;
			for (i = 0; i < sURLVariables.length; i++) {
				sParameterName = sURLVariables[i].split('=');
				if (sParameterName[0] === sParam) {
					return sParameterName[1] === undefined ? true : sParameterName[1];
				}
			}
			};

function replaceLast(string, from, to) {
     let lastIndex = string.lastIndexOf(from);
     if (lastIndex < 0) return string;
     let tail = string.substring(lastIndex).replaceFirst(from, to);
     return string.substring(0, lastIndex) + tail;
}			
			
var ref_from = getUrlParameter('ref_from');
var ref_lang = getUrlParameter('ref_lang');	
	
				
			

var submit = 'save';

	 $('button[type=submit]').on('click', function(){
		   submit = $(this).val();
	            	})
	            	
	 $("form").each(function(){
		 	var that = $(this);
		  that.appForm({	
			 	onSubmit: function(query){
				  console.log('query', query);
				  if(ref_from && ref_lang){
				  query.push({ name : 'ref_from', value: ref_from});
				  query.push({ name : 'ref_lang', value: ref_lang});
				  }
				  return query;
			  	},	
            	onAjaxSuccess: function(result){
	            	console.log('onAjaxSuccess',result);
	           // if(result.success){	
	            	appAlert.success(result.message, {container: '.app-content', duration: 3000});
	            	
	            	if(submit == 'save'){
	            		window.location.href = result.route;
	            		}else{
		        		
					var paths = location.pathname.split('/');
		        	var lastSegment = paths[ paths.length-1 ];
		        	var queryString = "";
					if(lastSegment == 'create'){
						paths[ paths.length-1 ] = 'edit'; // new value
						location.pathname = paths.join('/') + '/' + result.id;	
						if(ref_from && ref_lang){
							queryString+= "?ref_from=" + ref_from + "&ref_lang=" + ref_lang;	
						}
						//window.history.pushState("", "", "/" + location.pathname + queryString);
							window.history.pushState("", "", "/" + location.pathname);
					}
					
		        		
	            		}
	            	//}
            	},
				onError: function(response) {
					console.log(response);
				},				
			});
		 
	 });
    
    
});

*/
	 $('#search-list-category').keyup(function() {
        var textboxVal = $(this).val().toLowerCase();
       $(this).parent().find(".group-items li").each(function() {
            var listVal = $(this).text().toLowerCase();
            if(listVal.indexOf(textboxVal) >= 0) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
