<?php

namespace Modules\Member\Http\Controllers;

use Auth;
use Modules\Base\Http\Responses\BaseHttpResponse;
use Modules\Base\Traits\HasDeleteManyItemsTrait;
use Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Acl\Entities\Users;
use Modules\Member\Repositories\MemberInterface;
use Modules\Base\Events\CreatedContentEvent;
use Modules\Base\Events\UpdatedContentEvent;
use Modules\Base\Events\DeletedContentEvent;
use Modules\Member\Entities\Member;
use Modules\Member\Tables\MemberTable;
use Modules\Base\Forms\FormBuilder;
use Modules\Member\Forms\MemberForm;
use Carbon\Carbon;
use Assets;


class MemberController extends Controller
{
    use HasDeleteManyItemsTrait;
	 /**
     * @var MemberInterface
     */
    protected $member;


    public function __construct(
   		MemberInterface $member
   			)
    {
        $this->member = $member;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(MemberTable $table)
    {
	    page_title()->setTitle(__('member::member.list'));
        return $table->renderTable();
    }


    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create(FormBuilder $formBuilder)
    {
	   page_title()->setTitle(__('member::member.add'));
	   return $formBuilder->create(MemberForm::class)->renderForm();

    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request, BaseHttpResponse $response)
    {

		   $request->merge(array('status' => $request->has('status')?1:0));
		   $member = $this->member->create($request->all());

		 event(new CreatedContentEvent($request->all(), $member));

         return $response
            	->setPreviousUrl(route('member.index'))
				->setNextUrl(route('member.edit', $member->id))
				->setMessage(__('base::form-validate.add-success'));


    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('member::show');
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

        $subject = $this->member->find($id);

        page_title()->setTitle(__('member::member.edit'));

		return $formBuilder->create(MemberForm::class, ['model' => $subject])->renderForm();
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

	    $member = $this->member->update($id, $request->all());

        if($member){
	       event(new UpdatedContentEvent($request->all(), $member));
           return $response
           		 ->setPreviousUrl(route('member.index'))
		   		 ->setMessage(__('base::form-validate.update-success'));

         	}

    }

    public function restore(Request $request, BaseHttpResponse $response)
    {
	  $member = $this->member->getFirstByWithTrash(['members.id' => $request->id]);
      $this->member->restoreBy(['id' => $request->id]);
      event(new DeletedContentEvent($request->all(), $member, 'restore'));

	  return $response
           		 ->setPreviousUrl(route('member.index'))
		   		 ->setMessage(__('base::form-validate.update-success'));
    }
    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy(Request $request, $id)
    {
	   $member = $this->member->find($id);
       $this->member->delete($id);
       event(new DeletedContentEvent($request->all(), $member));

	   return Response::json(array(
        			'success' => true), 200);
    }

    public function deletes(Request $request, BaseHttpResponse $response)
      {
        return $this->executeDeleteItems($request, $response, $this->menus);
      }

}
