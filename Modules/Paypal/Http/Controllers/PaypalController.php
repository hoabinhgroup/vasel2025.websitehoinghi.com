<?php

namespace Modules\Paypal\Http\Controllers;

use Auth;
use Modules\Base\Http\Responses\BaseHttpResponse;
use Modules\Base\Traits\HasDeleteManyItemsTrait;
use Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Acl\Entities\Users;
use Modules\Paypal\Repositories\PaypalInterface;
use Modules\Base\Events\CreatedContentEvent;
use Modules\Base\Events\UpdatedContentEvent;
use Modules\Base\Events\DeletedContentEvent;
use Modules\Paypal\Entities\Paypal;
use Modules\Paypal\Tables\PaypalTable;
use Modules\Base\Forms\FormBuilder;
use Modules\Paypal\Forms\PaypalForm;
use Carbon\Carbon;
use Assets;


class PaypalController extends Controller
{
    use HasDeleteManyItemsTrait;
	 /**
     * @var PaypalInterface
     */
    protected $paypal;


    public function __construct(
   		PaypalInterface $paypal
   			)
    {
        $this->paypal = $paypal;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(PaypalTable $table)
    {
	    page_title()->setTitle(__('paypal::paypal.list'));
        return $table->renderTable();
    }


    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create(FormBuilder $formBuilder)
    {
	   page_title()->setTitle(__('paypal::paypal.add'));
	   return $formBuilder->create(PaypalForm::class)->renderForm();

    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request, BaseHttpResponse $response)
    {

		   $request->merge(array('status' => $request->has('status')?1:0));
		   $paypal = $this->paypal->create($request->all());

		 event(new CreatedContentEvent($request->all(), $paypal));

         return $response
            	->setPreviousUrl(route('paypal.index'))
				->setNextUrl(route('paypal.edit', $paypal->id))
				->setMessage(__('base::form-validate.add-success'));


    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('paypal::show');
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

        $subject = $this->paypal->find($id);

        page_title()->setTitle(__('paypal::paypal.edit'));

		return $formBuilder->create(PaypalForm::class, ['model' => $subject])->renderForm();
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

	    $paypal = $this->paypal->update($id, $request->all());

        if($paypal){
	       event(new UpdatedContentEvent($request->all(), $paypal));
           return $response
           		 ->setPreviousUrl(route('paypal.index'))
		   		 ->setMessage(__('base::form-validate.update-success'));

         	}

    }

    public function restore(Request $request, BaseHttpResponse $response)
    {
	  $paypal = $this->paypal->getFirstByWithTrash(['paypals.id' => $request->id]);
      $this->paypal->restoreBy(['id' => $request->id]);
      event(new DeletedContentEvent($request->all(), $paypal, 'restore'));

	  return $response
           		 ->setPreviousUrl(route('paypal.index'))
		   		 ->setMessage(__('base::form-validate.update-success'));
    }
    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy(Request $request, $id)
    {
	   $paypal = $this->paypal->find($id);
       $this->paypal->delete($id);
       event(new DeletedContentEvent($request->all(), $paypal));

	   return Response::json(array(
        			'success' => true), 200);
    }

    public function deletes(Request $request, BaseHttpResponse $response)
      {
        return $this->executeDeleteItems($request, $response, $this->menus);
      }

}
