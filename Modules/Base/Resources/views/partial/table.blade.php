@extends('base::cmspanel.layout.dashboard')

@push('styles')
 <link rel="stylesheet" type="text/css" href="/css/select2.min.css">    
@endpush

@section('content')
<style>
	
</style>

   <div class="content-body"> 
	      <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
               <!-- <h4 class="card-title">{{ explode('|', page_title()->getTitle())[0] }}</h4>-->
                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                <div class="heading-elements">
                  <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                  </ul>
                </div>
              </div>
              <div class="card-content collapse show">
	            
              <div class="card-body">
   
	   
	    
	 <div class="table-responsive">
		 
		<div class="table-toolbar"></div>
		  <div class="dataTables_wrapper dt-bootstrap4">
		  {!! $view !!}
		  </div>
     </div>
	
	 
              </div><!--.card-body-->
              </div><!-- .card-content -->
            </div><!-- .card-->
          </div>
	      </div>
      </div>

@stop

@push('scripts')
<script src="/js/select2.min.js"></script>
	@if(Session::has('success_msg'))
		<script> $(function() { $(document).ready(function(){
			appAlert.success("{{ Session::get('success_msg') }}", {container: 'body', duration: 3000});
		}); }); </script>
	@endif
	
	@if(Session::has('error_msg'))
		<script> $(function() { $(document).ready(function(){
			appAlert.error("{{ Session::get('error_msg') }}", {container: 'body', duration: 5000});
		}); }); </script>
	@endif
@endpush
