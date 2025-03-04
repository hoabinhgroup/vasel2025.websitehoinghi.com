<?php
namespace Modules\Menu\Http\Controllers;


use Module;
use Theme;
use Auth;
use Illuminate\Http\Request;
use Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Routing\Controller;
use Modules\Menu\Entities\Categories;
use Modules\Menu\Tables\MenuTable;
use Modules\Menu\Repositories\MenuInterface;
use Modules\Slug\Repositories\SlugInterface;
use Modules\Acl\Entities\Users;
use Modules\Menu\Libraries\Recursive;
use Modules\Base\Events\CreatedContentEvent;
use Modules\Base\Events\UpdatedContentEvent;
use Modules\Languages\Facades\LanguageFacade;
use Modules\Base\Http\Responses\BaseHttpResponse;
use Modules\Base\Forms\FormBuilder;
use Modules\Menu\Forms\MenuForm;
use Language;



class MenuController extends Controller
{
	 /**
     * @var MenuInterface
     */
    protected $menu;
    
     /**
     * @var SlugInterface
     */
    protected $slug;
    
     /**
     * @var LanguageMetaInterface
     */
    protected $langMeta;
    /**
	/**
     * @var LanguageMetaInterface
     */
    protected $lang;
    /**
     * @var MenuItemRepository
     */
    protected $menuItem;
  

   public function __construct(
   		MenuInterface $menu, 
   		SlugInterface $slug
   			)
    {
        $this->menu = $menu;
        $this->slug = $slug;

    }
	
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(MenuTable $table)
    {
	   
		page_title()->setTitle(__('menu::categories.list'));
	 	return $table->renderTable();
    }
    


    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create(FormBuilder $formBuilder)
    {
	    
	   page_title()->setTitle(__('menu::categories.add'));
	   return $formBuilder->create(MenuForm::class)->renderForm();
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request, BaseHttpResponse $response)
    {   
		   $request->merge(array('status' => $request->has('status')?1:0));
		    $requests = $request->request;
		    $requests->add(['user_id' => Auth::user()->id]);	 		   
		    $menu = $this->menu->create($request->all()); 	
		    
		 event(new CreatedContentEvent($request->all(), $menu));
		 	 				   				 			
         return $response
            	->setPreviousUrl(route('menu.index'))
				->setNextUrl(route('menu.edit', $menu->id))
				->setMessage(__('base::form-validate.add-success'));

         
		    			             		
    }

   
    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit(
    	$id, 
    	FormBuilder $formBuilder, 
    	Request $request
    )
    {
		
		$subject = $this->menu->find($id);
		page_title()->setTitle(__('menu::categories.edit'));

		return $formBuilder->create(MenuForm::class, ['model' => $subject])->renderForm();													

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
		BaseHttpResponse $response
    )
    {
	 
		$request->merge(array('status' => $request->has('status')?1:0));
	    $menu = $this->menu->update($id, $request->all());
	    	    	    
        if($menu){	         
	       event(new UpdatedContentEvent($request->all(), $menu));  			   									   
        	return $response
           		 ->setPreviousUrl(route('menu.index'))
		   		 ->setMessage(__('base::form-validate.update-success'));		
        			 
         	}        
        
	   
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy(Request $request)
    {
	
       $menu = $this->menu->delete($request->id);
	   
	   return Response::json(array(
        			'success' => true), 200);   
         
    }
}
