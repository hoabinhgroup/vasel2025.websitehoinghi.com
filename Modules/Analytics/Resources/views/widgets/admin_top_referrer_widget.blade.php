<div class="card">
<div class="card-header">
	<h4 class="card-title">Top Referrer</h4>
	<a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
	<div class="heading-elements">
	  <ul class="list-inline mb-0">
		<li><a data-action="collapse"><i class="ft-minus"></i></a></li>
		<li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
		<li><a data-action="close"><i class="ft-x"></i></a></li>
	  </ul>
	</div>
</div>
<div class="card-content">
	<div class="card-body" style="padding-top: 0px;">
			{!! app(\Modules\Analytics\Tables\AdminTopReferrerWidgetTable::class)->renderTable() !!} 			
	</div>
</div>
</div>
