@if (!empty($menu) && $menu->id)

<style>
	li{
		list-style-type: none;
	}
    .panel-collapse .panel-body{
        padding: 10px;
        background: #fff;
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
    <div class="row">
	<div class="col-md-3">
          <div class="panel-group accordion-3">

		 @php do_action(MENU_SIDEBAR, $menu) @endphp

         <div class="panel panel-info">
          <div class="panel-heading" data-toggle="collapse" data-parent=".accordion-3" href="#collapseCustomLink" aria-expanded="true">
              <h5 class="panel-title">{{ trans('menu::menu.add_link') }} <i class="fa fa-angle-down narrow-icon pull-right"></i></h5>
          </div>
          <div id="collapseCustomLink" class="panel-collapse in collapse" style="">
          <div class="panel-body">
          <div class="box-links-for-menu">
           <div id="external_link" class="the-box">
               <div class="node-content">
                   <div class="form-group">
                       <label for="node-title">{{ trans('menu::menu.title') }}</label>
                       <input type="text" class="form-control" id="node-title" autocomplete="false">
                   </div>
                   <div class="form-group">
                       <label for="node-url">{{ trans('menu::menu.url') }}</label>
                       <input type="text" class="form-control" id="node-url" placeholder="http://" autocomplete="false">
                   </div>
                   <div class="form-group">
                       <label for="node-icon">{{ trans('menu::menu.icon') }}</label>
                       <input type="text" class="form-control" id="node-icon" placeholder="fa fa-home" autocomplete="false">
                   </div>
                   <div class="form-group">
                       <label for="node-css">{{ trans('menu::menu.css_class') }}</label>
                       <input type="text" class="form-control" id="node-css" autocomplete="false">
                   </div>
                   <div class="form-group">
                       <label for="target">{{ trans('menu::menu.target') }}</label>
                       <div class="ui-select-wrapper">
                           <select name="target" class="ui-select" id="target">
                               <option value="_self">{{ trans('menu::menu.self_open_link') }}</option>
                               <option value="_blank">{{ trans('menu::menu.blank_open_link') }}</option>
                           </select>

           </div>
 </div>


                   <div class="form-group">
                       <div class="text-right add-button">
                           <div class="btn-group">
                               <a style="cursor:pointer" onclick="addExternalUrl()" class="btn-add-to-menu btn btn-primary"><span class="text"><i class="fa fa-plus"></i> {{ trans('menu::menu.add_to_menu') }}</span></a>
                           </div>
                       </div>
                   </div>

               </div>
           </div>
       </div>
       </div>
          </div>
         </div>


		  </div>
    </div>
    <div class="col-md-9">
    	<div class="dd dd-draghandle" id="nestable">

    	{!! (new RecursiveMenuNodes($menu->id))->build(0) ?? '<ol class="dd-list"></ol>' !!}


  		</div>
    </div>
	</div><!-- .row -->


 <script>
	var sourceAdd = '';
	var values = [];
	var backend = '{{ BACKEND }}';
	var id = '{{ $menu->id }}';


</script>
@endif
