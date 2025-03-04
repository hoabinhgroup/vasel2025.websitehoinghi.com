<?php

namespace Modules\Menu\Http\Controllers\Table;

use Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Response;
use Illuminate\Routing\Controller;
use Modules\Base\Http\Controllers\TableController;
use Modules\Menu\Repositories\MenuInterface;
use Modules\Menu\Libraries\Recursive;

class MenuController extends TableController
{
	 /**
     * @var MenuInterface
     */
    protected $repository;
    
    protected $table;
  

   public function __construct(
   		MenuInterface $repository
   			)
    {
        $this->repository = $repository;
        $this->table = $repository->getTable();     
        parent::__construct($repository);
    }
   
     /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */

     public function data(Request $request, MenuInterface $categories)
    {
	    if($request->ajax()){
		    
		$string = '-';
		    
       	 return $this->table($request)
       	 		 ->addColumn('action', 'menu::button.action_button')
       	 		 ->editColumn('name', function ($data) use ($string) {
	       	 		 if($data['level'] >= 2){
		       	 		 for($i = 1; $i < $data['level']; $i++){
			       	 		 $string.= '--';
		       	 		 }
		       	 		$name = $string .' '. $data['name'];
	       	 		 }else{
		       	 		$name = $data['name']; 
	       	 		 }
	       	 		 return $name;
	   	 		 	
				})
       	 		 ->editColumn('parent', function ($data) use ($categories) {
	       	 		 	$parent = $data['parent'];
	       	 		 	if($parent){
		       	 		return $categories->find($parent)['name'];
			   	 		 }else{
				   	 	return 0;	 
			   	 		 }
				})
	   	 		 ->rawColumns(['action'])
	   	 		 ->addIndexColumn()
       	 		 ->make(true);
        }
    }
    
    public function getDataTable($request)
	{
		$data = parent::getDataTable($request);

		$data = (new Recursive($data->toArray()))->buildArray($request->parent);

		$data = array_map(function($data, $k){
	        return array('index' => $k) + $data;
        },$data,  array_keys($data));
        
        return $data;
	}
    
	public function saveBulkChangeItem($id, $bulk_action)
	{
		return parent::saveBulkChangeItem($id, $bulk_action);	 
	}
	
	public function filterAfterSelect($data, $request)
	{
	
		return parent::filterAfterSelect($data, $request);	
	

	}

  
}
