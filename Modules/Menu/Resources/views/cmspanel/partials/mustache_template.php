 <script id="script_menu_nodes" type="text/x-handlebars-template">
	{{#each html}}
	<li id='sort_{{data.id}}' class='dd-item dd2-item item-orange' data-id='{{data.id}}'>
	<div class='dd-handle dd2-handle'>
	<i class='normal-icon ace-icon fa fa-bars blue bigger-130'></i><i class='drag-icon ace-icon fa fa-arrows bigger-125'></i></div>
	<div class='dd2-content'><span class="msg_{{id}}">{{data.title}}</span>
		<div class='pull-right action-buttons'>
		{{{ data.urlUpdate }}} &nbsp;&nbsp;
		{{{ data.urlDelete }}}
	</div>
   </li>
   {{/each}}
</script>

