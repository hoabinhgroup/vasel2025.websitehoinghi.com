<?php

namespace Modules\Seo\Http\Controllers;

use Auth;
use Modules\Base\Http\Responses\BaseHttpResponse;
use Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Acl\Entities\Users;
use Modules\Seo\Repositories\SeoInterface;
use Modules\Base\Events\CreatedContentEvent;
use Modules\Base\Events\UpdatedContentEvent;
use Modules\Seo\Entities\Seo;
use Modules\Seo\Tables\SeoTable;
use Modules\Base\Forms\FormBuilder;
use Modules\Seo\Forms\SeoForm;
use Carbon\Carbon;
use Assets;


class SeoController extends Controller
{
	 /**
     * @var SeoInterface
     */
    protected $seo;
 

    public function __construct(
   		SeoInterface $seo
   			)
    {
        $this->seo = $seo;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(SeoTable $table)
    {
	    page_title()->setTitle(__('seo::seo.list'));
        return $table->renderTable();
    }


    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create(FormBuilder $formBuilder)
    {
	   page_title()->setTitle(__('seo::seo.add'));
	   return $formBuilder->create(SeoForm::class)->renderForm();

    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request, BaseHttpResponse $response)
    {

		   $request->merge(array('status' => $request->has('status')?1:0));	   
		   $seo = $this->seo->create($request->all()); 	
		    
		 event(new CreatedContentEvent($request->all(), $seo));
	   				 			
         return $response
            	->setPreviousUrl(route('seo.index'))
				->setNextUrl(route('seo.edit', $seo->id))
				->setMessage(__('base::form-validate.add-success'));		
         
		 
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('seo::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit(
   		$id, 
    	FormBuilder $formBuilder, 
    	Request $request)
    {
	   
        $subject = $this->seo->find($id);
        
        page_title()->setTitle(__('seo::seo.edit'));

		return $formBuilder->create(SeoForm::class, ['model' => $subject])->renderForm(); 												
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(
    	Request $request, 
    	$id, 
		BaseHttpResponse $response)
    {
        
		$request->merge(array('status' => $request->has('status')?1:0));
		
	    $seo = $this->seo->update($id, $request->all());
	    	    	    
        if($seo){	         
	       event(new UpdatedContentEvent($request->all(), $seo));  			   				
           return $response
           		 ->setPreviousUrl(route('seo.index'))
		   		 ->setMessage(__('base::form-validate.update-success'));		
        			
         	}        
      
    }
    
    public function restore(Request $request, BaseHttpResponse $response)
    {

      $this->seo->restoreBy(['id' => $request->id]);
	   
	  return $response
           		 ->setPreviousUrl(route('seo.index'))
		   		 ->setMessage(__('base::form-validate.update-success'));  
    }
    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
       $this->seo->delete($request->id);
	   
	   return Response::json(array(
        			'success' => true), 200);  
    }
  
}
