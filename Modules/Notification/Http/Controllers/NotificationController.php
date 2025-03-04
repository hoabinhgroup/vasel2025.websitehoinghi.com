<?php

namespace Modules\Notification\Http\Controllers;

use Auth;
use Modules\Base\Http\Responses\BaseHttpResponse;
use Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Acl\Entities\Users;
use Modules\Notification\Repositories\NotificationInterface;
use Modules\Base\Events\CreatedContentEvent;
use Modules\Base\Events\UpdatedContentEvent;
use Modules\Base\Events\DeletedContentEvent;
use Modules\Notification\Entities\Notification;
use Modules\Notification\Tables\NotificationTable;
use Modules\Base\Forms\FormBuilder;
use Modules\Notification\Forms\NotificationForm;
use Carbon\Carbon;
use Assets;


class NotificationController extends Controller
{
	 /**
     * @var NotificationInterface
     */
    protected $notification;
 

    public function __construct(
   		NotificationInterface $notification
   			)
    {
        $this->notification = $notification;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(NotificationTable $table)
    {
	    
	    page_title()->setTitle(__('notification::notification.list'));
        return $table->renderTable();
    }


    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create(FormBuilder $formBuilder)
    {
	   page_title()->setTitle(__('notification::notification.add'));
	   return $formBuilder->create(NotificationForm::class)->renderForm();

    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request, BaseHttpResponse $response)
    {

		   $request->merge(array('status' => $request->has('status')?1:0));	   
		   $notification = $this->notification->create($request->all()); 	
		    
		 event(new CreatedContentEvent($request->all(), $notification));
	   				 			
         return $response
            	->setPreviousUrl(route('notification.index'))
				->setNextUrl(route('notification.edit', $notification->id))
				->setMessage(__('base::form-validate.add-success'));		
         
		 
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('notification::show');
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
	   
        $subject = $this->notification->find($id);
        
        page_title()->setTitle(__('notification::notification.edit'));

		return $formBuilder->create(NotificationForm::class, ['model' => $subject])->renderForm(); 												
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
		
	    $notification = $this->notification->update($id, $request->all());
	    	    	    
        if($notification){	         
	       event(new UpdatedContentEvent($request->all(), $notification));  			   				
           return $response
           		 ->setPreviousUrl(route('notification.index'))
		   		 ->setMessage(__('base::form-validate.update-success'));		
        			
         	}        
      
    }
    
    public function restore(Request $request, BaseHttpResponse $response)
    {
	  $notification = $this->notification->getFirstByWithTrash(['notifications.id' => $request->id]);
      $this->notification->restoreBy(['id' => $request->id]);
      event(new DeletedContentEvent($request->all(), $notification, 'restore'));
	   
	  return $response
           		 ->setPreviousUrl(route('notification.index'))
		   		 ->setMessage(__('base::form-validate.update-success'));  
    }
    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy(Request $request, $id)
    {
	   $notification = $this->notification->find($id);
       $this->notification->delete($id);
       event(new DeletedContentEvent($request->all(), $notification));
	   
	   return Response::json(array(
        			'success' => true), 200);  
    }
    
    public function getSlug(Request $request, $id)
    {
	    return Response::json(array(
        			'id' => $id), 200);
    }
  
	public function markAsRead(){
	   auth()->user()->unreadNotifications->markAsRead();
   }
}
