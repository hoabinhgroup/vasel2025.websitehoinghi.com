<?php

namespace Modules\Api\Http\Controllers;

use Auth;
use Modules\Base\Http\Responses\BaseHttpResponse;
use Modules\Base\Traits\HasDeleteManyItemsTrait;
use Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Acl\Entities\Users;
use Modules\Api\Repositories\ApiInterface;
use Modules\Base\Events\CreatedContentEvent;
use Modules\Base\Events\UpdatedContentEvent;
use Modules\Base\Events\DeletedContentEvent;
use Modules\Api\Entities\Api;
use Modules\Api\Tables\ApiTable;
use Modules\Base\Forms\FormBuilder;
use Modules\Api\Forms\ApiForm;
use Carbon\Carbon;
use Assets;


class ApiController extends Controller
{
    use HasDeleteManyItemsTrait;
	 /**
     * @var ApiInterface
     */
    protected $api;


    public function __construct(
   		ApiInterface $api
   			)
    {
        $this->api = $api;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(ApiTable $table)
    {
	    page_title()->setTitle('Bill payment Info');
        return $table->renderTable();
    }


    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create(FormBuilder $formBuilder)
    {
	   page_title()->setTitle('Add bill payment');
	   return $formBuilder->create(ApiForm::class)->renderForm();

    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request, BaseHttpResponse $response)
    {
       // echo '<pre>';print_r($request->all());echo '</pre>'; die();
       
		   $request->merge(
         array('due_date' => Carbon::createFromFormat('d/m/Y H:i:s', $request->due_date)->format("Y-m-d H:i:s"))
        );
		   $api = $this->api->create($request->all());

		// event(new CreatedContentEvent($request->all(), $api));

         return $response
            	->setPreviousUrl(route('api.index'))
				->setNextUrl(route('api.edit', $api->id))
				->setMessage(__('base::form-validate.add-success'));


    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('api::show');
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

        $subject = $this->api->find($id);

        page_title()->setTitle(__('api::api.edit'));

		return $formBuilder->create(ApiForm::class, ['model' => $subject])->renderForm();
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

	    $api = $this->api->update($id, $request->all());

        if($api){
	       event(new UpdatedContentEvent($request->all(), $api));
           return $response
           		 ->setPreviousUrl(route('api.index'))
		   		 ->setMessage(__('base::form-validate.update-success'));

         	}

    }

    public function restore(Request $request, BaseHttpResponse $response)
    {
	  $api = $this->api->getFirstByWithTrash(['apis.id' => $request->id]);
      $this->api->restoreBy(['id' => $request->id]);
      event(new DeletedContentEvent($request->all(), $api, 'restore'));

	  return $response
           		 ->setPreviousUrl(route('api.index'))
		   		 ->setMessage(__('base::form-validate.update-success'));
    }
    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy(Request $request, $id)
    {
	   $api = $this->api->find($id);
       $this->api->delete($id);
       event(new DeletedContentEvent($request->all(), $api));

	   return Response::json(array(
        			'success' => true), 200);
    }

    public function deletes(Request $request, BaseHttpResponse $response)
      {
        return $this->executeDeleteItems($request, $response, $this->menus);
      }

}
