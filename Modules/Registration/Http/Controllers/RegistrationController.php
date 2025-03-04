<?php

namespace Modules\Registration\Http\Controllers;

use Auth;
use Modules\Base\Http\Responses\BaseHttpResponse;
use Modules\Base\Traits\HasDeleteManyItemsTrait;
use Modules\Base\Enums\BaseStatusEnum;
use Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Acl\Entities\Users;
use Modules\Registration\Repositories\RegistrationInterface;
use Modules\Base\Events\CreatedContentEvent;
use Modules\Base\Events\UpdatedContentEvent;
use Modules\Base\Events\DeletedContentEvent;
use Modules\Registration\Entities\Registration;
use Modules\Registration\Tables\RegistrationTable;
use Modules\Registration\Tables\SubscribeTable;
use Modules\Base\Forms\FormBuilder;
use Modules\Registration\Forms\RegistrationForm;
use Modules\Registration\Exports\RegistrationExport;
use Carbon\Carbon;
use Assets;
use Excel;


class RegistrationController extends Controller
{
  use HasDeleteManyItemsTrait;
  /**
   * @var RegistrationInterface
   */
  protected $registration;


  public function __construct(
    RegistrationInterface $registration
  ) {
    $this->registration = $registration;
  }

  /**
   * Display a listing of the resource.
   * @return Response
   */
  public function index(RegistrationTable $table)
  {
    page_title()->setTitle(__('registration::registration.list'));

    $table = $table->renderTable();

    return $table;
  }


  public function subscribe(SubscribeTable $table)
  {

    page_title()->setTitle(__('registration::subscribe.list'));

    $table = $table->renderTable();

    return $table;
  }

  public function export()
  {
    return Excel::download(new RegistrationExport, 'registration_' . Carbon::now() . '.xlsx');
  }

  /**
   * Show the form for creating a new resource.
   * @return Response
   */
  public function create(FormBuilder $formBuilder)
  {
    page_title()->setTitle(__('registration::registration.add'));
    return $formBuilder->create(RegistrationForm::class)->renderForm();
  }

  /**
   * Store a newly created resource in storage.
   * @param Request $request
   * @return Response
   */
  public function store(Request $request, BaseHttpResponse $response)
  {

    $request->merge(array('status' => $request->has('status') ? 1 : 0));
    $registration = $this->registration->create($request->all());

    event(new CreatedContentEvent($request->all(), $registration));

    return $response
      ->setPreviousUrl(route('registration.index'))
      ->setNextUrl(route('registration.edit', $registration->id))
      ->setMessage(__('base::form-validate.add-success'));
  }

  /**
   * Show the specified resource.
   * @param int $id
   * @return Response
   */
  public function show($id)
  {
    return view('registration::show');
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
  ) {

    $subject = $this->registration->find($id);

    page_title()->setTitle(__('registration::registration.edit'));

    return $formBuilder->create(RegistrationForm::class, ['model' => $subject])->renderForm();
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
  ) {

    $request->merge(array('status' => $request->has('status') ? 1 : 0));

    $registration = $this->registration->update($id, $request->all());

    if ($registration) {
      event(new UpdatedContentEvent($request->all(), $registration));
      return $response
        ->setPreviousUrl(route('registration.index'))
        ->setMessage(__('base::form-validate.update-success'));
    }
  }

  public function restore(Request $request, BaseHttpResponse $response)
  {
    $registration = $this->registration->getFirstByWithTrash(['registrations.id' => $request->id]);
    $this->registration->restoreBy(['id' => $request->id]);
    event(new DeletedContentEvent($request->all(), $registration, 'restore'));

    return $response
      ->setPreviousUrl(route('registration.index'))
      ->setMessage(__('base::form-validate.update-success'));
  }
  /**
   * Remove the specified resource from storage.
   * @param int $id
   * @return Response
   */
  public function destroy(Request $request, $id)
  {
    $registration = $this->registration->find($id);
    $this->registration->delete($id);
    event(new DeletedContentEvent($request->all(), $registration));

    return Response::json(array(
      'success' => true
    ), 200);
  }

  public function deletes(Request $request, BaseHttpResponse $response)
  {
    return $this->executeDeleteItems($request, $response, $this->registration);
  }
}
