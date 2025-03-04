<?php
namespace Modules\Post\Http\Controllers;

use Module;
use Theme;
use Auth;
use Illuminate\Http\Request;
use Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Routing\Controller;
use Modules\Post\Entities\Categories;
use Modules\Post\Tables\CategoriesTable;
use Modules\Post\Repositories\CategoriesInterface;
use Modules\Slug\Repositories\SlugInterface;
use Modules\Acl\Entities\Users;
use Modules\Menu\Libraries\Recursive;
use Modules\Base\Events\CreatedContentEvent;
use Modules\Base\Events\UpdatedContentEvent;
use Modules\Base\Events\DeletedContentEvent;
use Modules\Languages\Facades\LanguageFacade;
use Modules\Base\Http\Responses\BaseHttpResponse;
use Modules\Base\Forms\FormBuilder;
use Modules\Post\Forms\CategoriesForm;
use Language;



class CategoriesController extends Controller
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
   		CategoriesInterface $categories,
   		SlugInterface $slug
   			)
    {
        $this->categories = $categories;
        $this->slug = $slug;

    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(CategoriesTable $table)
    {

		page_title()->setTitle(__('post::categories.list'));
	 	return $table->renderTable();
    }



    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create(FormBuilder $formBuilder)
    {

	   page_title()->setTitle(__('post::categories.add'));
	   return $formBuilder->create(CategoriesForm::class)->renderForm();
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request, BaseHttpResponse $response)
    {
		    $requests = $request->request;
		    $requests->add(['user_id' => Auth::user()->id]);
		    $categories = $this->categories->create($request->all());

		 event(new CreatedContentEvent($request->all(), $categories));

         return $response
            	->setPreviousUrl(route('categories.index'))
				->setNextUrl(route('categories.edit', $categories->id))
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

		$subject = $this->categories->find($id);
		page_title()->setTitle(__('post::categories.edit'));

		return $formBuilder->create(CategoriesForm::class, ['model' => $subject])->renderForm();

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

	    $categories = $this->categories->update($id, $request->all());

        if($categories){
	       event(new UpdatedContentEvent($request->all(), $categories));
        	return $response
           		 ->setPreviousUrl(route('categories.index'))
		   		 ->setMessage(__('base::form-validate.update-success'));

         	}


    }

    public function restore(Request $request, BaseHttpResponse $response)
    {
	  $categories = $this->categories->getFirstByWithTrash(['categories.id' => $request->id]);
      $this->categories->restoreBy(['id' => $request->id]);
      event(new DeletedContentEvent($request->all(), $categories, 'restore'));

	  return $response
           		 ->setPreviousUrl(route('categories.index'))
		   		 ->setMessage(__('base::form-validate.update-success'));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy(Request $request, $id)
    {
	   $categories = $this->categories->find($id);
       $this->categories->delete($id);
       event(new DeletedContentEvent($request->all(), $categories));

	   return Response::json(array(
        			'success' => true), 200);

    }
}
