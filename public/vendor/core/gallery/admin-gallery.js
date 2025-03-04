	save_data_albums();

	 $('.iframe-btn').fancybox({	
	'width'		: 900,
	'minHeight'	: 600,
	'type'		: 'iframe',
    'autoScale'    	: false
    });
    
    function deleteAlbumImage(o)
    {
	   $(o).parent().remove();
	   save_data_albums();
    }
    
    function isJson(item) {
    item = typeof item !== "string"
        ? JSON.stringify(item)
        : item;

    try {
        item = JSON.parse(item);
    } catch (e) {
        return false;
    }

    if (typeof item === "object" && item !== null) {
        return true;
    }

    return false;
}
       
    function responsive_filemanager_callback_gallery(field_id){
	   
	
	var url=jQuery('#'+field_id).val();
	//$("#txt-image").attr('src',url);
	
	//url = url.split(',');
	//url = JSON.parse([url]);
	
	console.log('json or no',isJson(url));
	
	show_data_albums(url);

	save_data_albums();
	 
	}	
	
	function show_data_albums(url)
	{
		if(isJson(url)){
			url = JSON.parse(url);
			$.each(url, function( index, value ) {
		value = '/' + value.substr(value.indexOf('/', 7) + 1);
	  var image = '<div class="photo-gallery-item" data-id="NaN" data-img="'+value+'" data-description=""><div class="gallery_image_wrapper"><img src="'+value+'"></div><a onClick="deleteAlbumImage(this);"><i class="fa fa-trash"></i></a></div>';
	$("#list-photos-items").append(image);
			});
		}else{
	url = '/' + url.substr(url.indexOf('/', 7) + 1);		
		var image = '<div class="photo-gallery-item" data-id="NaN" data-img="'+url+'" data-description=""><div class="gallery_image_wrapper"><img src="'+url+'"></div><a onClick="deleteAlbumImage(this);"><i class="fa fa-trash"></i></a></div>';
	$("#list-photos-items").append(image);	
		}
		
	}
	
	function save_data_albums()
	{
		 var albums = []; 
		 $(".photo-gallery-item").each(function(){
			 var img = $(this).attr('data-img');
		 		albums.push({img: img});
			});
		$("#txt-gallery-hidden").val(JSON.stringify(albums));	
	}
	
	var options = {
		
	onStart: function (/**Event*/evt) {
		evt.oldIndex;  // element index within parent
		console.log('onStart',evt.oldIndex);
		//save_data_albums();
	},
	
	onEnd: function (/**Event*/evt) {
		var itemEl = evt.item;  // dragged HTMLElement
		console.log('onEnd',itemEl);
		save_data_albums();
		}
	}
	var el = document.getElementById('list-photos-items');
	var sortable = Sortable.create(el, options);
	
	function close_window() {
    parent.$.fancybox.close();
	} 
	
	$(".reset-gallery").on("click",function(e){
		e.preventDefault(),$(".list-photos-gallery .photo-gallery-item").remove();
		});
	