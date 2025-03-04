<?php

namespace Modules\Registration\Http\Controllers;

use Auth;
use Modules\Registration\Entities\InviteeRegistrationVn;
use Modules\Registration\Exports\InviteeRegistrationVnExport;
use Modules\Registration\Tables\InviteeRegistrationVnTable;
use Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Base\Events\DeletedContentEvent;
use Carbon\Carbon;
use Assets;
use Excel;


class InviteeRegistrationVnController extends Controller
{

  /**
   * Display a listing of the resource.
   * @return Response
   */
  public function index(InviteeRegistrationVnTable $table)
  {
    page_title()->setTitle('Danh sách Invitee Registration VN');

    $table = $table->renderTable();

    return $table;
  }



  public function export()
  {
    return Excel::download(new InviteeRegistrationVnExport, 'invitee_registration_vn_' . Carbon::now() . '.xlsx');
  }


  /**
   * Remove the specified resource from storage.
   * @param int $id
   * @return Response
   */
  public function destroy(Request $request, $id)
  {
    $registration = InviteeRegistrationVn::find($id);
    $registration->delete();
    event(new DeletedContentEvent($request->all(), $registration));

    return Response::json(array(
      'success' => true
    ), 200);
  }

}
