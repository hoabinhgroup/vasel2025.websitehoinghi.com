$(document).on("click", ".btn-clear-cache", function(e) {
                        e.preventDefault();
                        var t = $(e.currentTarget);
                        t.addClass("button-loading"), $.ajax({
                            url: t.data("url"),
                            type: "POST",
                            data: {
                                type: t.data("type")
                            },
                            success: function(e) {
                                t.removeClass("button-loading");
                                if(e.error){
	    
	                       appAlert.error(e.message, {container: 'body', duration: 3000});
                                }else{
	                     
	                      appAlert.success(e.message, {container: 'body', duration: 3000});          
                                }
                                
                            },
                            error: function(e) {
                                t.removeClass("button-loading");
                                console.log(e);
                            }
                        })
});