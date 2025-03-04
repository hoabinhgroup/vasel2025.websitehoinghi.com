<?php

namespace Modules\Post\Http\Controllers;

use Auth;
use Modules\Base\Http\Responses\BaseHttpResponse;
use Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Acl\Entities\Users;
use Modules\Post\Repositories\TagInterface;
use Modules\Base\Events\CreatedContentEvent;
use Modules\Base\Events\UpdatedContentEvent;
use Modules\Base\Events\DeletedContentEvent;
use Modules\Post\Entities\Tag;
use Modules\Post\Tables\TagTable;
use Modules\Base\Forms\FormBuilder;
use Modules\Post\Forms\TagForm;
use Carbon\Carbon;
use Assets;


class TagController extends Controller
{
	 /**
     * @var PostInterface
     */
    protected $tag;


    public function __construct(
   		TagInterface $tag
   			)
    {
        $this->tag = $tag;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(TagTable $table)
    {
	   /* $query = $this->tag
            ->select(['*'], [])->get()->toArray();

        echo "<pre>";
        print_r($query);
        echo "</pre>";   die();  */

	    page_title()->setTitle(__('post::tag.list'));
        return $table->renderTable();
    }


    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create(FormBuilder $formBuilder)
    {
	   page_title()->setTitle(__('post::tag.add'));
	   return $formBuilder->create(TagForm::class)->renderForm();

    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(
    	Request $request,
    	BaseHttpResponse $response)
    {

		   $requests = $request->request;
		   $requests->add(['author_id' => Auth::user()->id]);
		   $tag = $this->tag->create($request->all());

		 event(new CreatedContentEvent($request->all(), $tag));

         return $response
            	->setPreviousUrl(route('tag.index'))
				->setNextUrl(route('tag.edit', $tag->id))
				->setMessage(__('base::form-validate.add-success'));


    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('post::show');
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

        $subject = $this->tag->find($id);

        page_title()->setTitle(__('post::tag.edit'));

		return $formBuilder->create(TagForm::class, ['model' => $subject])->renderForm();
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



	    $tag = $this->tag->update($id, $request->all());

        if($tag){
	       event(new UpdatedContentEvent($request->all(), $tag));

           return $response
           		 ->setPreviousUrl(route('tag.index'))
		   		 ->setMessage(__('base::form-validate.update-success'));

         	}

    }


    public function getAllTags()
    {
        return $this->tag->pluck('name');
    }
    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy(Request $request, $id)
    {
	   $tag = $this->tag->find($id);
       $this->tag->delete($id);
       event(new DeletedContentEvent($request->all(), $tag, 'force'));

	   return Response::json(array(
        			'success' => true), 200);
    }

}
