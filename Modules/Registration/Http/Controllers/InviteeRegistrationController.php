<?php

namespace Modules\Registration\Http\Controllers;

use Auth;
use Modules\Registration\Entities\InviteeRegistration;
use Modules\Registration\Exports\InviteeRegistrationExport;
use Modules\Registration\Tables\InviteeRegistrationTable;
use Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Base\Events\DeletedContentEvent;
use Carbon\Carbon;
use Assets;
use Excel;


class InviteeRegistrationController extends Controller
{

  /**
   * Display a listing of the resource.
   * @return Response
   */
  public function index(InviteeRegistrationTable $table)
  {
    page_title()->setTitle('Danh sách Invitee Registration');

    $table = $table->renderTable();

    return $table;
  }



  public function export()
  {
    return Excel::download(new InviteeRegistrationExport, 'invitee_registration_' . Carbon::now() . '.xlsx');
  }


  /**
   * Remove the specified resource from storage.
   * @param int $id
   * @return Response
   */
  public function destroy(Request $request, $id)
  {
    $registration = InviteeRegistration::find($id);
    $registration->delete();
    event(new DeletedContentEvent($request->all(), $registration));

    return Response::json(array(
      'success' => true
    ), 200);
  }

}
