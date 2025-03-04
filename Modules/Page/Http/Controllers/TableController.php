<?php

namespace Modules\Page\Http\Controllers;

use Auth;
use DataTables;
use Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Acl\Entities\Users;
use Modules\Page\Repositories\PageInterface;
use Modules\Page\Entities\Page;
use Carbon\Carbon;
use DB;
use Assets;
//use Language;

class TableController extends Controller
{
	 /**
     * @var PageInterface
     */
    protected $page;


   public function __construct(
   		PageInterface $page
   			)
    {
        $this->page = $page;
    }

    
    public function data(Request $request)
    {
	    if($request->ajax()){
		    
		  $this->bulkAction($request);
		  
		  $data = $this->get_content_tab($request)['data'];	
		  
       	 return Datatables::of($data)
       	 		 ->addColumn('action', 'page::button.action_button')
       	 		 ->addColumn('check', '<div class="pretty p-icon p-round">
        <input type="checkbox" class="ace"  name="table_checkbox[]" value="{{ $id }}"  />
        <div class="state">
            <i class="icon fa fa-check"></i>
            <label></label>
        </div>
		</div>')
       	 		 ->editColumn('created_at', function ($data) {
	       	 		$date = Carbon::parse($data['created_at']);
		   	 		return $date->format('d/m/Y h:i A'); 
	       	 	
				 })
				 ->editColumn('updated_at', function ($data) {
	       	 		$date = Carbon::parse($data['updated_at']);
		   	 		return $date->format('d/m/Y h:i A'); 
	       	 	
				 })
       	 		 ->editColumn('status', function ($data) {
	       	 		 $status = $data['status']?'Kích hoạt':'Chưa kích hoạt';
	       	 		return '<div class="badge badge-info">'. $status .'</div>';
	       	 	
				 })
       	 		 ->editColumn('user_id', function ($data) {
	       	 		 	return Users::find($data['user_id'])->name;
	       	 	
				 })
	   	 		 ->rawColumns(['action'])
	   	 		 ->addIndexColumn()
	   	 		 ->with('actions', $this->get_content_tab($request)['actions'])
       	 		 ->make(true);
        }
    }
    
    function bulkAction($request)
	{
		$bulk_action = $request->bulk_action;
		$countAllCheckbox = $request->countAllCheckbox;
		
		if($bulk_action && $countAllCheckbox){
	     foreach($countAllCheckbox as $item):	       
	         if($item){	
		        		        	       					
		        if($bulk_action == 'trash'){			        
			        $page = Page::find($item);
			        if($page){
				       $page->delete();	
			        }
			        	        
		         }elseif($bulk_action == 'restore'){
			         Page::withTrashed()->find($item)->restore();
			     }elseif($bulk_action == 'publish'){
				     $this->page->update($item, ['status' => 1]);			       
		         }elseif($bulk_action == 'draft'){
			         $this->page->update($item, ['status' => 0]);      
		         }elseif($bulk_action == 'delete'){
			          $page = Page::withTrashed()->find($item);
			        if($page){
				       $page->forceDelete();
			        }		
			        
		         }
		         
	            }
	         endforeach;
		}
		return true;
	}	
	
	function get_content_tab($request){
		   $tab_active = 0;
		   $anchor_tab = $request->anchor_tab ?? '';
		   if ($anchor_tab) {
	        if($anchor_tab == 'trash'){
           $data = $this->page->getAllPagesTrash(true) ?? [];
           $tab_active = "trash";
            }
       	   }else{		  	    		    
		   $data = $this->page->getAllPages(false) ?? [];
		   }
		   
		   return [
			   'data' => $data,
			   'actions' => [
		   	 		 'trash' => $this->page->getAllPagesTrash(true)->count(),
		   	 		 'all' => $this->page->getAllPages(false)->count(),
		   	 		 'tab_active' => $tab_active
	   	 		 ]	
		   ];
	}

   
}
