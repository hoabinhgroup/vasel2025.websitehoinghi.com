@extends('base::cmspanel.layout.dashboard')

@section('title',' - Tạo menu')

@push('styles')
<style>
	.content-box{
		margin-top: 20px;
	}
	.nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active{
		border-top: 1px solid #ddd;
		border-left: 1px solid #ddd;
		border-right: 1px solid #ddd;
	}
</style>
<style>
	li{
		list-style-type: none;
	}
	.orange{
		color: #f78716;
	}
	.update_content_block{
		margin-left: 40px;
	}
	.select-box .group-items{
		
	}
	.select-box > .group-items{
		padding-left: 0px;
	}
	
	.select-box > .group-items > .group-items{
		padding-left: 10px;
	}
	.select-box > .group-items > .group-items > .group-items{
		padding-left: 10px;
	}

.panel-body .search-control{
	padding: 5px;
	margin-bottom: 5px;
}

/*** Nav ***/
.navbar-default { background-color: #f5f5f5; box-shadow: 0 1px 0 0 rgba(0,0,0,0.1); }
  .navbar-default .nav>li>a:focus, 
  .navbar-default .nav>li>a:hover { background-color: #e5e5e5; }

.panel-title{
	padding: 10px;
	background: #E3E8ED;
}
/*** Content ***/
#home{
	margin-bottom: 10px;
}
main {}

  .i-row-odd { background-color: #ffffff; }
  .i-row-even { background-color: #f7f7f7; }

.section-title { margin-top: 0; margin-bottom: 0.6em; font-weight: 500; }
.section-title .fa { margin-right: 5px; color: #6f5499; }



/******************************************/

.i-accordion .panel-heading,
.d-accordion .panel-heading,
.accordion-2a .panel-heading,
.accordion-2b .panel-heading,
.accordion-3 .panel-heading { cursor: pointer; }
.d-accordion .panel-heading.collapsed .fa-chevron-up:before { content: '\f078'; }
</style>

<link rel="stylesheet" type="text/css" href="/css/drag-menu.css">
<link rel="stylesheet" type="text/css" href="/assets/css/jquery-ui.custom.css">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pretty-checkbox@3.0/dist/pretty-checkbox.min.css">
<link rel="stylesheet" type="text/css" href="/assets/css/chosen.css">
@endpush

@section('sidebar')
	@parent
@stop

@section('content')
<div class="content-wrapper">
 <div class="card-header">
	  		<h3 class="card-title">Sửa Menu</h3>
       </div>
	<div class="content-body"> 
	      <div class="row">
 	<div class="col-12">
            <div class="card">
  
               <div class="card-content collapse show">
                <div class="card-body">	   

@include('languages::partials.langtabs', 
	['options' => array_merge(
		$langMeta, [
					'route_create' => 'backend.menus.create', 
					'route_edit' => 'backend.menus.edit']
					)])                
                                   
<div class="content-box">
			{{ Form::open(array('route' => ['backend.menus.update', $id ?? ''], 'id' => 'menuForm')) }}
			@if (isset($_GET['ref_from']))
			{!! Form::hidden('ref_from', $_GET['ref_from']) !!}
			@endif
			@if (isset($_GET['ref_lang']))
			{!! Form::hidden('ref_lang', $_GET['ref_lang']) !!}
			@endif
			<div class="row">
				<div class="col-md-9">
				<div class="form-group">
				{{ Form::label('name', 'Tiêu đề:') }}
				{{ Form::text('name', $menu['name'] ?? '', [
						'class' => 'form-control',
						'data-rule-required' => 'true',
						'data-msg-required' => 'Bắt buộc nhập'
						]) }}
				</div>
				<div class="form-group">
				{{ Form::label('slug', 'Đường dẫn:') }}
				{{ Form::text(
					'slug', 
					 $menu['slug']['key'] ?? '', 
					 	[
					 	  'class' => 'form-control',
					 	  'data-rule-required' => 'true',
					 	  'data-msg-required' => 'Bắt buộc nhập'
					 	  ]) }}
				</div>
				
			</div>
			<div class="col-md-3">
				
				<div class="form-group">
					<label for="">Kích hoạt</label><br/>					
					<div class="pretty p-switch p-fill">
					{!! Form::checkbox('status', 1, 
						($menu['status'])? true : false) !!}
					<div class="state">
					<label>Kích hoạt/ Bỏ kích hoạt</label>
        			</div>
				</div>
				
				</div>
				<div class="form-group">
					{!! Form::button('<i class="icon-check"></i> Lưu', ['type' => 'submit', 'class' => 'btn btn-info'] ) !!}
				</div>
			</div>
			</div><!-- .row -->

			{{ Form::close() }}
	@php 
	
	@endphp		
	
	<div class="row">	
	<div class="col-md-3">        
          <div class="panel-group accordion-3">     
	
		 @php do_action(MENU_SIDEBAR, $langMeta['lang_meta_code']) @endphp
			 
		  </div>
    </div>	
    <div class="col-md-9">
    	<div class="dd dd-draghandle" id="nestable">
    	
    	{!! (new RecursiveMenuNodes($id))->build(0) ?? '<ol class="dd-list"></ol>' !!}
				

  		</div>
    </div>
	</div><!-- .row -->	
	
                </div><!--.card-body-->
               </div><!-- .card-content -->
            </div>
          </div>
	      </div>
	</div>
</div>
@stop

@push('scripts')  
 <script src="/assets/js/bootstrap-multiselect.js" type="text/javascript"></script>	
 <script src="/assets/js/chosen.jquery.js" type="text/javascript"></script>	
 <script src="/js/handlebars-v4.0.11.js" type="text/javascript"></script>	
  <script src="/js/plugins/jquery.nestable.min.js" type="text/javascript"></script>	
<script>
	$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
	});

$(function() {   
	$.validator.addMethod("valueNotEquals", function(value, element, arg){
   console.log(element.value);
    return 0 != element.value; 
}, "Value must not equal arg.");
	 
    $("#menuForm").appForm({			
            	onAjaxSuccess: function(result){
	            	console.log('onAjaxSuccess',result);
	            if(result.success){	
	            	appAlert.success('ok', {container: 'body', duration: 3000});
	            	window.location.href = '{{ route("menu.index") }}';
	            	}
            	},
				onError: function(response) {
					console.log(response);
				},				
			});
    
});


	</script>	
	
	

	 <script>
	var sourceAdd = '';	 
	var values = [];
/* P */
$('.accordion-2a, .accordion-2b, .accordion-3').on('show.bs.collapse', function(n){
  $(n.target).siblings('.panel-heading').find('.panel-title i').toggleClass('fa-chevron-down fa-chevron-up');
});
$('.accordion-2a, .accordion-2b, .accordion-3').on('hide.bs.collapse', function(n){
  $(n.target).siblings('.panel-heading').find('.panel-title i').toggleClass('fa-chevron-up fa-chevron-down');
});
		 

		 
		 function uncheckedall(o)
		 {
	
	var elementChecked = $(o).parent().find('.checkbox_value');
	   elementChecked.each(function(e){
		  if($(this).prop('checked')){
			  var valueChecked = $(this).val();	
			  $(this).prop("checked", false);		
			var result = values.filter(function(elem){
			return elem != valueChecked; 
				});
			values.splice(values[result], 1);
		
			//values = [];
			console.log(values);	
				
		}
	   });
		
		
		 	
			}
		 
		
	//getChecked();
	      
	     $("input[class='checkbox_value']:checkbox").on('click', function(){
		const that = $(this);
		$(this).each(function() {
			if(that.prop('checked')){
			values.push(that.attr("id"));
			arr = values;		
			}else{
			jQuery.each(values,function(i,item){
				if(arr[i] == that.attr("id")) {
					arr.splice(i, 1);
				}
			});
			values = arr;	
			}	
			console.log(values);
		});	
	}); 
	     	
		
		  function importMenuNode(namespace, lang){
		   	console.log(namespace);
			if(values.length == 0){
			alert("Bạn phải chọn tối thiểu 1 menu!");	
			} else{
			
			$.ajax({
            type: "POST",
            url: "{!! route('backend.menunode.import') !!}",
            data: {
	            data: values,
	            namespace: namespace,
	            menu_id: '{{$id}}',
	            lang: lang
            },
            beforeSend: function (){
	            //jQuery('#loading-indicator').show();
            },
            success: function (obj) {
             console.log('importMenuNode',obj); 
            //return false;
       
        var source = $("#script_menu_nodes").html();
			var template = Handlebars.compile(source);
			$("#nestable").children('ol').append(template({html: obj}));
            
            },
            error: function(error){
	            console.log('error',error); 
	            return false;
            }
            
            
        });
        
			}
	    
    		}
    		
    		function deleteMenuNode(o){
	    	    var node = $(o).closest('.dd-item').attr("data-id");
	    	    var url = $(o).attr('data-url');    		
	    		jQuery.ajax({
            type: "POST",
            url: url,
            beforeSend: function (){
	            //jQuery('#loading-indicator').show();
            },
            success: function (obj) {
             console.log(obj); 
			 $("#sort_" + node).fadeOut();          
            },
            error:function(error){
	            console.log(error);
            }
            
        });
    		}
		 
		 $(document).ready(function () {
   $('input[type=checkbox]').click(function () {
        // if is checked
        if ($(this).is(':checked')) {
           // $(this).parents('ul').prev().children('input[type=checkbox]').prop('checked', true);
            $(this).parent().find('li input[type=checkbox]').prop('checked', true);    
        } else {   
            $(this).parents('li').children('input[type=checkbox]').prop('checked', false);
            // uncheck all children
            $(this).parent().find('li input[type=checkbox]').prop('checked', false);  
        }
    });
    
    
});

    

var updateOutput = function(e)
    {

        var list   = e.length ? e : $(e.target),
            output = list.data('output');
        if (window.JSON) {
	      var data =  list.nestable('serialize');
           console.log('updateOutputBefore',data);
            
            $.ajax({
	        url: '{!! route('backend.menunode.sort') !!}',
	        type: "POST",
            data: {
	            dataString: data,
	            menu_id: '{{ $id }}'
	            },
          success: function ( data ) {
           // alert(data);
           console.log('updateOutput',data);
      
         
        	},
        	error: function(error){
	        	console.log('error',error);
        	}
           
        });
        } else {
            output.val('JSON browser support required for this demo.');
        }
    };

  
	
    // activate Nestable for list 1
    $('#nestable').nestable({
        group: 1
    })
    .on('change', updateOutput);

   
    // output initial serialised data
    updateOutput($('#nestable').data('output', $('#nestable-output')));

			
	$('.dd-handle a').on('mousedown', function(e){
		e.stopPropagation();
	});
				
				//$('[data-rel="tooltip"]').tooltip();
				
			
</script>	
@endpush
