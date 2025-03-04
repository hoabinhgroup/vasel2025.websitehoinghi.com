$(document).ready(function(){
;(($) => {
    'use strict';
    const pluginName = 'louisTable';
    var dataPlugin = "plugin_" + pluginName;
    var defaults = {
	    url: "",
	    create_button: '',
	    bulk_action: false,
	    tabbar: false,
	    sorting: [[ 1, "desc" ]],
	    columns: [],
        limit: 10,
        hideTools: false,
        filterDropdown: [],       
        dateRange: false,
        maxPages: 7,
        selectors: {
            template: $("#customer"),
			list: $('#customer-list'),
			frmBulkAction: $("#form-bulk-action"),
			paging: $('#paging'),  
			limit: $('select[name=limit]'),   
			userId: $("#userId"),
			others: $("#others"),
			ckAll: $("#ck_All"),
			multi: $(".confirmMulti"),
			multiHandle: $(".multiHandle")
        },
        modalHide: true,
        animateScrolltop: true,
        isModal: false,
        ajaxUrl: true,
        destroy: false,
        loading: true,
        sort: {},
        onAjaxSuccess: function (){},
        onImportSuccess: function (){},
        onChosenSuccess: function (){},
        onComplete: function () {},
        onError: function () {},
        loadOnStart: true,
        onLoad: () => {}
    };

    // The actual plugin constructor
    function Plugin(element, options) {
        this.element = element;
        this.settings = $.extend({}, defaults, options);
        this._defaults = defaults;
        this._name = pluginName;
        this.page = 1;
        this.loading = true;
        this.reload = false;
        this.search = '';
        this.currentData = {};
        this.dataString = {};
        this.filterParams = [];
        this.init();
    }
    
  

    // Avoid Plugin.prototype conflicts
    $.extend(Plugin.prototype, {
        init() {
	        const that = this;

	        var url = window.location.href;

	        if(that.settings.ajaxUrl){
	        var current = url.substring(url.lastIndexOf('/') + 1);
		if ($.isNumeric(current)) {
			that.page = current;
			}
			}
			
			that._buildCache();
			that._bindEvents();
	               },
	    _test(){
			alert(12);    
	    },  
	     onForward(callback){
                    this.onForward      = callback; // setting the callback after initialization
                },         
	     _destroy() {
		      
		  this.unbindEvents();
		 // $(this.element).unbind('.'+this._name);
		 // $(this.element).removeData();
		 this.$element.unbind('.'+this._name);
		 this.$element.removeData();
        
        },    
	     _buildCache() {
            this.$element = $(this.element);
        },   
        _bindEvents(){
	        const that = this;
	      
	         
            
              if ($(that.settings.selectors.multi).length ) {   
           that.settings.selectors.multi.on('click', (e) => {
		   		that._confirmMulti(e.currentTarget);
		  	});
            }   
            
                if ($(that.settings.selectors.multiHandle).length ) {   
           that.settings.selectors.multiHandle.on('click', (e) => {
		   		that._multiHandle(e.currentTarget);
		  	});
            }        
                   

	         if ($(that.settings.selectors.type).length ) { 
	        that.settings.selectors.type.on("change", (e) => {
		   		that._change(e.currentTarget);
		  	});
	         }
	         
	         
	        	         
	        
		  	
		  	/* that.$element.parent().find("input[type='checkbox']").on("change", (e) => {
		        that._checkbox(e.currentTarget);
		   		
		  	});
		  	*/
	  
			
			 if ($(that.settings.selectors.userId).length ) { 
			that.settings.selectors.userId.on("change", (e) => {
		   		that._change(e.currentTarget);
		  	});
			}
			
	
			
			 if ($(that.settings.selectors.others).length ) { 
			that.settings.selectors.others.on("change", (e) => {
		   		that._change(e.currentTarget);
		  	});
			}

				
			 if ($(that.settings.selectors.quality).length ) { 
			that.settings.selectors.quality.on("change", (e) => {
		   		that._change(e.currentTarget);
		  	});
			}
			
			 if ($(that.settings.selectors.ckAll).length ) { 
			that.settings.selectors.ckAll.on("change", function(){
				var checkAllElement = document.getElementsByName("table_checkbox[]");
				var i, countAllCheckbox = [];
				if(document.getElementById("ck_All").checked)
				{
				for( i = 0;i < checkAllElement.length;i++){
				checkAllElement[i].checked = true;
				if (checkAllElement[i].checked) 
				{
				countAllCheckbox.push(checkAllElement[i].value);
    			}
         	}
		 	}
		 	else {
		 	for( i = 0;i < checkAllElement.length;i++)
		 	checkAllElement[i].checked = false;

			}
		// $(".countSelected").text(countAllCheckbox.length);
			});
			}

			

	         
	       $(".search-select-category").on('click', function(){
			$("#search-category-name").text($(this).text());
			$("#filter_select").val($(this).attr("data-post-id"));
		  }); 
		  
		  
		  that.$element.closest(".table-responsive").find("button[data-type='search']").on('click', function(e){	
			 // console.log($(this).parent().children());       
                   that._search($(this).parent().children());
                        });
		  
		
		 /* if ($(that.settings.selectors.frmSearch).length ) { 
		  that.settings.selectors.frmSearch.submit((e) => {	         
                    that._search(e.currentTarget);
                        }); 
                 }
                 */
       
          
          // if ($(that.settings.selectors.frmBulkAction).length ) { 
	        
		  that.settings.selectors.frmBulkAction.submit((e) => {	       
                    that._apply(e.currentTarget);
                    
                        }); 
             //    }  
         
                 
           if ($(that.settings.selectors.frmCustomer).length ) { 
		  that.settings.selectors.frmCustomer.submit((e) => {	         
                    that.load();
                        }); 
                 }       
                    
       if(that.settings.dateRange){   
	       
	   that.$element.closest(".table-responsive").find(".tool").append('<div class="input-group"><div class="p-1 col-md-12"><input type="text" name="dates" class="form-control"></div></div>'); 
	        
       if( that.$element.find('input[name="dates"]')){	       
	         $('input[name="dates"]').daterangepicker({
			 "startDate": moment().subtract(5, 'day'),
			 "endDate": moment(),
			 locale: { 
			 format: 'DD/MM/YYYY'
				},
			 ranges: {
           'HÃ´m nay': [moment(), moment()],
           'HÃ´m qua': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           '7 ngÃ y trÆ°á»›c': [moment().subtract(6, 'days'), moment()],
           '30 ngÃ y trÆ°á»›c': [moment().subtract(29, 'days'), moment()],
           'ThÃ¡ng nÃ y': [moment().startOf('month'), moment().endOf('month')],
           'ThÃ¡ng trÆ°á»›c': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
			   });
			} 
				
			 $('input[name="dates"]').on('apply.daterangepicker', function(ev, picker) {
				 that._datepicker(picker);
			
			});
	       }

                 
	          
            if (this.settings.loadOnStart) {
                this.load();
            }
            
           /*  if (this.settings.reload) {
                this.load();
            }
            
            */
       
  
          
         that.$element.find("tbody").on('click', '[data-action=chosen]', (e) => {	 
                      that._chosenHandler(e.currentTarget);
                        });
                        
         that.$element.find("tbody").on('click', '[data-action=import]', (e) => {	 
                      that._importHandler(e.currentTarget);
                        });                 
          
         that.$element.find("thead").on('click', '[data-action=backup]', (e) => {	 

                     that._backupHandler(e.currentTarget);
                        });  
         
         that.$element.find("tbody").on('click', '[data-action=download]', (e) => {	 

                     that._downloadHandler(e.currentTarget);
                        });                
                        
            
          that.$element.find("tbody").on('click', '[data-action=delete]', (e) => {	 
  
                     that._deleteHandler(e.currentTarget);
                        });
            
         
          that.$element.find("tbody").on('click', '[data-action=delete-confirmation]', (e) => {	         
                     that._deleteConfirmationHandler(e.currentTarget, e);
                        });
                        
             $('body').on('click', '[data-action=reload]', (e) => {	   
                     that._reloadTable(that.$element);
                        } );

	var checkboxes =  that.$element.find("input[name='table_checkbox[]']"); 
		

	        
        },
         unbindEvents() {
            /*
                Unbind all events in our plugin's namespace that are attached
                to "this.$element".
            */
            this.$element.off('.'+this._name);
        },
         _datepicker(picker){
	        const that = this;
	       that.filterParams['start_date']  = picker.startDate.format('DD/MM/YYYY'); 
	       that.filterParams['end_date'] = picker.endDate.format('DD/MM/YYYY');
			that.load();
        },
        _change(e){
	        const that = this;
	        that.filterParams[$(e).attr("name")] = $(e).val();
	        that._load();
	       // console.log($(e).attr("name"));
        },
        _checkbox(e){
	        const that = this;
	       
	        if($(e).is(":checked")){
		      that.filterParams[$(e).attr("name")] = $(e).val();
	        }else{
		      that.filterParams[$(e).attr("name")] = 0;   
	        }
	        
			that.load();
	        console.log($(e).attr("name"));
        },
        _changePage(o) {
	        // const that = this;
	       if(this.settings.animateScrolltop){
            $('html, body').animate({
        scrollTop: this.$element.parent().offset().top
				}, 200);
				}
		 var $target = $(o);
		 console.log('target',$target);
		 console.log(this);
	   this.page = 1; 
	   this.filterParams['url'] = $target.attr("data"); 
	   
	   var current = this.filterParams['url'].substring(this.filterParams['url'].lastIndexOf('/') + 1);
		if ($.isNumeric(current)) {
			this.page = current;
			}
	   this.load();
	   
        },
        _reload(){
	        const that = this;
	         var table = that.$element.dataTable();
          
            table.fnReloadAjax(that.filterParams);
            return false;
        },
        _reloadTable(e){
	       //location.reload();	       
	       this.load();
        },
        _deleteConfirmationHandler(e, event){
	       var alert = confirm("Bạn muốn xoá?");
            if(alert){
	            this._deleteHandler(e);
            }
            event.stopImmediatePropagation(); 
        },  
	     _deleteHandler(e){
		      const that = this;
		     var $target = $(e),
                    url = $target.attr('data-action-url'),
                    id = $target.attr('data-post-id');
            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                data: {id: id},
                success: function(result) { 
	                console.log(result);
	                that.loading = false;
	                that._load();                
                    
                },
                error: function(response){
	                console.log(response);
                }
            });
		  return false;
	     },
	    _backupHandler(e){
		     const that = this;
		     var $target = $(e),
                    url = $target.attr('data-action-url');
  
            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                data: {},
                success: function(result) { 
	                 console.log('backuplist',result); 
	                that.loading = false;
	                that.load();
	                
                    if (result.success) {	                    
	                    var alertId = appAlert.success(result.message, {duration: 3000});
	                    
                    } else {
                        appAlert.error(result.message, {duration: 3000});
                    }
                    
                },
                error: function(response){
	                console.log(response);
                }
            });
		  return false;
	    }, 
	    _downloadHandler(e){
		     const that = this;
		     var $target = $(e),
                    url = $target.attr('data-action-url'),
                    id = $target.attr('data-post-id');
  
            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                data: {id: id},
                success: function(result) { 
	                 console.log('downloadlist',result); 
	                that.loading = false;
	                that.load();
	                
                    if (result.success) {	                    
	                    var alertId = appAlert.success(result.message, {duration: 3000});
	                    
                    } else {
                        appAlert.error(result.message, {duration: 3000});
                    }
                    
                },
                error: function(response){
	                console.log(response);
                }
            });
		  return false;
	    },
	     _multiHandle(e){
		       const that = this;
		      var ids = [];
    $("input[name='table_checkbox[]']:checked").each(function () {	
	   var param = $(this).closest("tr").attr("id").split("_");
	   var paramId = param[1];
     ids.push(paramId);
	 }); 
	
	 if(ids.length != 0){
		
     $.ajax({
                url: $(e).attr('data-action-url'),
                type: 'POST',
                dataType: 'json',
                data: {Ids: ids},
                success: function(result) { 
	                console.log(result);

	                that.load();
	            
                    if (result.success) {	                    
	                    var alertId = appAlert.success(result.message, {duration: 3000});
	                    
                    } else {
                        appAlert.error(result.message);
                    }
                    
                },
                error: function(response){
	                console.log(response);
                }
            });
    //that.load();
    
    
    }else{
	    alert('Báº¡n cáº§n chá»n Ã­t nháº¥t 1 Ä‘á»‘i tÆ°á»£ng!');
    }
	     },
	     _confirmMulti(e){
		       const that = this;
		      var ids = [];
    $("input[name='table_checkbox[]']:checked").each(function () {	
	   var param = $(this).closest("tr").attr("id").split("_");
	   var paramId = param[1];
     ids.push(paramId);
	 }); 
	
	 
	 if(ids.length != 0){
		 if (confirm("Báº¡n cÃ³ Ä‘á»“ng Ã½ vá» viá»‡c nÃ y?")) {
     $.ajax({
                url: $(e).attr('data-action-url'),
                type: 'POST',
                dataType: 'json',
                data: {trashIds: ids},
                success: function(result) { 
	                console.log(result);

	                that.load();
	            
                    if (result.success) {	                    
	                    var alertId = appAlert.success(result.message, {duration: 3000});
	                    
                    } else {
                        appAlert.error(result.message, {duration: 3000});
                    }
                    
                },
                error: function(response){
	                console.log(response);
                }
            });
    //that.load();
    
     	}
    }else{
	    alert('Báº¡n cáº§n chá»n Ã­t nháº¥t 1 Ä‘á»‘i tÆ°á»£ng!');
    }
	     },
	     _updateAward(customerId, adward){
		   $("#customer_"+ customerId).children("td").eq(6).text(adward);   
	     },
	     _chosenHandler(e){
		     const that = this;
		   console.log(that);
		  
		      var $target = $(e),
                    url = $target.attr('data-action-url'),
                    id = $target.attr('data-post-id'),
                    customer_id = $target.attr('data-post-customer_id');      
                    
		     var alert = confirm("Báº¡n muá»‘n thÃªm dá»‹ch vá»¥ cho khÃ¡ch hÃ ng nÃ y?");
            if(alert){
	            var queryString = {id: id, customer_id: customer_id};
	$.ajax({
			type: "POST",
			url: url,
			data: queryString,
			dataType: 'json',
			success: function(result) { 
				that.settings.onChosenSuccess(result);            
                    if (result.success) {	                    
	                  var alertId = appAlert.success(result.message, {duration: 3000});
	                    
                    } else {
                        appAlert.error(result.message);
                    }
                    
                },
		    error: function(response){
			    console.log(response);
			    
		    }
		});
		
		  return false;
            }
          
	     },
	     _importHandler(e){
		     const that = this;

		      var $target = $(e),
                    url = $target.attr('data-action-url'),
                    id = $target.attr('data-post-id');
        
                    
		     var alert = confirm("Báº¡n muá»‘n import dá»¯ liá»‡u upload nÃ y vÃ o báº£ng khÃ¡ch hÃ ng?");
            if(alert){
	            var queryString = {import_id: id};
	        $.ajax({
			type: "POST",
			url: url,
			data: queryString,
			dataType: 'json',
			success: function(result) { 
				console.log('_importHandler',result);
				
				that.settings.onImportSuccess(result);
                    if (result.success) {	
	                  
	                    var alertId = appAlert.success(result.message, {duration: 3000});
	                    
                    } else {
                        appAlert.error(result.message, {duration: 3000});
                    }
                  // $('.modal').modal('hide'); 
                },
		    error: function(response){
			    console.log(response);
			    
		    }
		});
	        
            }
          
	     },
        _search(e) {
		event.preventDefault();
		console.log($(e).serializeArray());
	    this.filterParams['keyword'] = $(e).serializeArray()[0]['value'];
	   // this.filterParams['field'] = $(e).serializeArray()[1]['value'];
	    this.filterParams['page'] = 1;
	    this.load();
        },
        _apply(e){
	         event.preventDefault();  
	       
	        this.filterParams['bulk_action'] = $(e).serializeArray()[0]['value'];
	        //countAllCheckbox
	       let countAllCheckbox = [];
	      $("input[name='table_checkbox[]']:checked").each(function () {	

				countAllCheckbox.push($(this).val());
				
			 });  
						             
			
		 
	  if (countAllCheckbox.length <= 0) {
			// alert("Xin chọn ít nhất 1 đối tượng!");	
			  appAlert.error("Xin chọn ít nhất 1 đối tượng!", {container: 'body', duration: 3000});		
		}else{
			this.filterParams['countAllCheckbox'] = countAllCheckbox; 
			
			 console.log('_apply',this.filterParams);
			if (this.filterParams['bulk_action'] == 0) {
				//alert("Bạn phải chọn 1 thao tác!");
				appAlert.error("Bạn phải chọn 1 thao tác!", {container: 'body', duration: 3000});
				
			}else if(this.filterParams['bulk_action'] == 'delete'){
			var alert = confirm("Bạn muốn xóa?");
            if(alert){
	            this.filterParams['bulk_action'] == 'delete';
	            this._load();
            }else{
	            this.filterParams['bulk_action'] = '';
            }
			}else{
				appAlert.success("Áp dụng thành công!", {container: 'body', duration: 3000});
				this._load();
			}
	
		}
		
		
		
        },
	     _anchorTab(e){
		    const that = this; 
		    var $target = $(e),
		    		key = $target.attr('data-action'),
                    value = $target.attr('data-post-key');
                    //console.log(key);
                    //console.log(value);
                    that.filterParams[key] = value;
                   // console.log('_anchorTab', value);
                    //that.filterParams['page'] = 1;
                    // $target.siblings().removeClass("active");
                   // $target.addClass("active");
                    //console.log('xxx',that.filterParams);
                   // that._reload();
                    that._load();
                   // that.$element.DataTable().ajax.reload();
                    //that._ajaxload();
	     },
        _temp(response) {	
	        const that = this; 
            var source = that.$element.children("script").html();
			var template = Handlebars.compile(source);
			var data = response['data'];
		if($(data).length == 0){
			that.$element.find("tbody").html('<tr class="odd"><td valign="top" colspan="100%" style="vertical-align:middle" class="dataTables_empty text-center">KhÃ´ng cÃ³ káº¿t quáº£ Ä‘Æ°á»£c tÃ¬m tháº¥y</td></tr>');
		}else{ 
			that.$element.find("tbody").html(template({html: data}));
		}
	
	
	
	/*	that.$element.find('.start_number').text(response['start']);
		that.$element.find('.current_number').text(response['current']);
		that.$element.find('.total_number').text(response['count']);   
		that.$element.find('#paging').html(response['paging']);
		*/
		that.$element.parent().find('.start_number').text(response['start']);
		that.$element.parent().find('.current_number').text(response['current']);
		that.$element.parent().find('.total_number').text(response['count']);   
		that.$element.parent().find('#paging').html(response['paging']);
			
        },
        _bindSelectButtons() {
            const that = this;
            $('.' + this.element.id + 'BtnSelectAll').click(() => {
                that._selectAll();
            });
            $('.' + this.element.id + 'BtnSelectNone').click(() => {
                that._selectNone();
            });
        },
        _selectAll() {
            if (this.loading) {
                return;
            }
            $('.' + this.element.id + 'Checkbox').prop('checked', true);
        },
        _filter(data){
	         this.dataString['url'] = this.settings.ajaxUrl ? window.location.href : '';
			 this.dataString['page'] = this.page;
			 this.dataString['limit'] = this.settings.limit;
	  
	 
			for(var key in data) { 
   if (data.hasOwnProperty(key)) {
       if (typeof(data[key]) == "undefined") {
			this.dataString[key] = $("#"+ key).val();
			}else{
			this.dataString[key] = data[key];
			}
	   }
	
	   }
	   return this.dataString;
        },
        _selectNone() {
            if (this.loading) {
                return;
            }
            $('.' + this.element.id + 'Checkbox').prop('checked', false);
        },
        _loading(show) {       
           appLoader.show();
        },
        _beforeSend(e) {
	        if(this.settings.loading){
			// appLoader.show();
			 run_waitMe(this.$element.find('tbody'), 1, 'bounce');
			 }
        },
        getCurrentData() {
            return this.currentData;
        },
        _load(){
	        
	         //const that = this;
	        // var table = this.$element.dataTable();
          this.$element.DataTable().clear();
          this.load();
           // table.fnReloadAjax(this.filterParams);
           // return false;
	        
	       // this.$element.load({reload: true, filterParams: this.filterParams});
	      // this.reload();
	      //  this.$element.dataTable().fnDeleteRow($(this).closest('tr').remove()); 
			//this.$element.dataTable().fnDraw(); 
	      // this.$element.DataTable().clear().destroy();
			//this.load(); 
			// this.$element.DataTable().ajax.reload();
        },
        _ajaxload(){
	        
	        if (!this.settings.url) {
                return;
            }
            
            const that = this;
            var html = '';
            //this.loading = true;
            
        var datatableOptions = {
		dom: 'lfrtBip',
		sorting: that.settings.sorting,
        processing: true,
        serverSide: true,
        smart: true,
        "language": {
			processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> ',
			emptyTable:     "Không có dữ liệu",
			info: "Hiển thị _START_ đến _END_ / _TOTAL_ dòng",
			infoEmpty:      "Hiển thị 0 đến 0 / 0 dòng",
			infoFiltered:   "(đã lọc từ _MAX_ dòng)",
			lengthMenu:     "Hiển thị _MENU_",
			search:         "Tìm kiếm:",
			zeroRecords:    "Không có dữ liệu được tìm thấy",
			paginate: {
				"first":      "First",
				"last":       "Last",
				"next":       "Next",
				"previous":   "Previous"
			},
			
		},
        ajax: {
	        url: that.settings.url,
	        data: that._filter(that.filterParams)
        },
        columns: that.settings.columns,
        initComplete: function(settings, json) {
	        console.log(json);
	       
			
			},
		 fnInitComplete: function(data){
			if(that.settings.tabbar){
				console.log('data.json.actions', data.json.actions);
				//render_tabbar(data);
			}	 
		 	that.settings.onAjaxSuccess(data);
         },
         error: function (xhr, error, code)
            {
                console.log(error);
                console.log(code);
            }
    };
    
   
    
     if (!that.settings.hideTools) {
           // datatableOptions.sDom = "<'datatable-tools row'<'col-md-3'l><'col-md-9 custom-toolbar'f>r>t<'datatable-tools row clearfix'<'col-md-3'i><'col-md-9'p>>";
           datatableOptions.sDom = "<'datatable-tools row'<'col-md-9 custom-toolbar'><'col-md-3'f>r>t<'datatable-tools row clearfix'<'col-md-4'li><'col-md-8'p>>";
        }
        

  		  that.$element.DataTable(datatableOptions);
	        
        },
        load() {

            if (!this.settings.url) {
                return;
            }
            
            const that = this;
            var html = '';
            //this.loading = true;
            
        var datatableOptions = {
		dom: 'lfrtBip',
		sorting: that.settings.sorting,
        processing: true,
        serverSide: true,
        smart: true,
        "language": {
			processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> ',
			emptyTable:     "Không có dữ liệu",
			info: "Hiển thị _START_ đến _END_ / _TOTAL_ dòng",
			infoEmpty:      "Hiển thị 0 đến 0 / 0 dòng",
			infoFiltered:   "(đã lọc từ _MAX_ dòng)",
			lengthMenu:     "Hiển thị _MENU_",
			search:         "Tìm kiếm:",
			zeroRecords:    "Không có dữ liệu được tìm thấy",
			paginate: {
				"first":      "First",
				"last":       "Last",
				"next":       "Next",
				"previous":   "Previous"
			},
			
		},
        ajax: {
	        url: that.settings.url,
	        data: that._filter(that.filterParams)
        },
        columns: that.settings.columns,
        initComplete: function(settings, json) {
	        console.log(json);
	       
			
			},
		 fnInitComplete: function(data){
			if(that.settings.tabbar){
				console.log('data.json.actions', data.json.actions);
				render_tabbar(data);
			}	 
		 	that.settings.onAjaxSuccess(data);
         },
         error: function (xhr, error, code)
            {
                console.log(error);
                console.log(code);
            }
    };
    
   
    
     if (!that.settings.hideTools) {
           // datatableOptions.sDom = "<'datatable-tools row'<'col-md-3'l><'col-md-9 custom-toolbar'f>r>t<'datatable-tools row clearfix'<'col-md-3'i><'col-md-9'p>>";
           datatableOptions.sDom = "<'datatable-tools row'<'col-md-9 custom-toolbar'><'col-md-3'f>r>t<'datatable-tools row clearfix'<'col-md-4'li><'col-md-8'p>>";
        }
        
        
        // reload
      /*  if (that.settings.reload) {
            var table = that.$element.dataTable();
            var instanceSettings = window.InstanceCollection[that.$element.selector];
            if (!instanceSettings) {
                instanceSettings = that.settings;
            }
            table.fnReloadAjax(instanceSettings.filterParams);
            return false;
        }
        */
        

  		  that.$element.DataTable(datatableOptions);
  		
  		  
  		  	  // Bulk action
  		  if(this.settings.bulk_action){
  		  var bulk_action = '';
  	
  		  bulk_action += '<div id="section_bulk_action">';
  		  bulk_action += '<select id="bulk_action" class="w200 select2 select2-size" name="bulk_action"><option value="0">-- Bulk Action --</option><option value="publish">Kích hoạt </option><option value="draft">Chưa kích hoạt</option><option value="trash">Xoá tạm</option><option value="restore">Khôi phục</option><option value="delete">Xoá vĩnh viễn</option></select>';
  		  bulk_action += '<button type="submit" class="btn btn-info">Áp dụng</button></div>';
  		  
  		  
  		  
  		  $(".custom-toolbar").append(bulk_action);
  		  
  		   $(".select2").select2();  
          $("button[type=submit]").on('click', function(e){
	            that._apply($(this).parent().children('#bulk_action'));
          });
          }
          
          // Tabbar
          if(this.settings.tabbar){
          $(".custom-toolbar").parent().append('<div class="tabbar">(<span id="all_tab" class="count">0</span>) <a href="javascript:void(0)" title="Xem tất cả" class="anchor_tab active" data-action="anchor_tab" data-post-key="0">Xem tất cả</a>  -  (<span id="trash_tab" class="count">0</span>) <a href="javascript:void(0)" title="Danh sách xoá tạm" class="anchor_tab" data-action="anchor_tab" data-post-key="trash" data-action-url="">Danh sách xoá tạm</a></div>');
          
           that.$element.parent().on('click', 'a.anchor_tab', (e) => {	
                      that._anchorTab(e.currentTarget);
                        });
          }
  		 
  		  
  		  if(that.settings.create_button){
	  		  let name = (that.settings.create_button[0].name)? that.settings.create_button[0].name : '<i class="icon-plus font-weight-bold"></i> Thêm';
	  		  let url = that.settings.create_button[0].url;
	  		  let attr = (that.settings.create_button[0].attr) ? that.settings.create_button[0].attr : [{'class': 'btn btn-info mr15 pull-left', 'title': 'Thêm'}];
	  		  var create_button = '';
	  		  let attributes = '';
	  		  
	  		   $.each(attr[0], function(index, value) {
		  		   attributes+= index + ' = "' + value + '" ';
		  		   //console.log('that.settings.create_button.value',value);
		  		  }); 
	  		  
	  		  create_button += '<a href="' + url + '" ' + attributes + '>'+ name +'</a>';
	  		 
	  		 
	  		  console.log('that.settings.create_button.href',create_button);
  		  }
  		  
	  	
          
  		  //$("#form-bulk-action").appendTo(".custom-toolbar");
  		  
  		  $(".custom-toolbar").append(create_button);
  		  
  		  $(".dataTables_info").css('left','150px');
  		  
  		  $('.dataTables_filter > label').contents().filter(function() {
  return this.nodeType === Node.TEXT_NODE;
}).remove();

 		

 		$('.dataTables_filter > label > input').attr('placeholder','Tìm kiếm...');
  		  
          var $instanceWrapper =  that.$element.closest(".table-responsive");	
			 
          	 if (typeof that.settings.filterDropdown[0] !== 'undefined') {
	          	 
            var radiobuttons = "";
           
            $.each(that.settings.filterDropdown, function(index, dropdown) {
                var optons = "", selectedValue = "";

                $.each(dropdown.options, function(index, option) {
                    var isSelected = "";
                    if (option.isSelected) {
                        isSelected = "selected";
                        selectedValue = option;
                    }
                    optons += '<option ' + isSelected + ' value="' + index + '">' + option + '</option>';
                });

                if (dropdown.name) {
                    that.filterParams[dropdown.name] = selectedValue;
                }

                var selectDom = '<div class="mr15 DTTT_container">'
                        + '<select class="' + dropdown.class + '" name="' + dropdown.name + '">'
                        + optons
                        + '</select>'
                        + '</div>';
                console.log($instanceWrapper);
               // $instanceWrapper.children(".table-toolbar").append(selectDom);
                $(".custom-toolbar").append(selectDom); 	

                var $dropdown = $instanceWrapper.find("[name='" + dropdown.name + "']");
                if (window.Select2 !== undefined) {
                    
                }
                $dropdown.select2();


		/*	that.$element.closest(".table-responsive").find("select").on("change", (e) => {
		      // console.log('aa',e.currentTarget);
		   		that._change(e.currentTarget);
		   		});
            */
             $dropdown.change(function(e) {
                    var $selector = $(this);
                    that._change(e.currentTarget);
                }); 
	
		});
	
	
	};
  			
  			function render_tabbar(data){
  			 	that.$element.parent().find("#trash_tab").text(data.json.actions.trash);	  
  			 	that.$element.parent().find("#all_tab").text(data.json.actions.all);
  			 	$("a[class='anchor_tab'").siblings().removeClass("active");
  			 	$("a[data-post-key='"+ data.json.actions.tab_active +"'").addClass("active");
			}
    
		
	          
	          if(that.settings.destroy){
			 that._destroy();
			    }
	          
	        return false;
        }
        
        
    });
    
    $.fn.dataTableExt.oApi.fnReloadAjax = function(oSettings, filterParams) {
            this.fnClearTable(this);
            this.oApi._fnProcessingDisplay(oSettings, true);
            var that = this;
            $.ajax({
                url: oSettings.ajax.url,
                type: "POST",
                dataType: "json",
                data: filterParams,
                success: function(json) {
	                console.log('fnReloadAjax',json);
                    /* Got the data - add it to the table */
                    for (var i = 0; i < json.data.length; i++) {
                        that.oApi._fnAddData(oSettings, json.data[i]);
                    }

                    oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();
                    that.fnDraw(that);
                    that.oApi._fnProcessingDisplay(oSettings, false);
                }
            });
        };
    
    // Plugin wrapper
    $.fn[pluginName] = function(options) {
        var plugin;
        this.each(function() {
            plugin = $.data(this, 'plugin_' + pluginName);
            if (!plugin) {
                plugin = new Plugin(this, options);
                $.data(this, 'plugin_' + pluginName, plugin);
            }
        });
        return plugin;
    };
})(jQuery, window, document);
});