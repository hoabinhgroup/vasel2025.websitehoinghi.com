<?php

namespace Modules\Registration\Http\Controllers;

use Auth;
use Modules\Base\Http\Responses\BaseHttpResponse;
use Modules\Registration\Entities\SpeakerRegistration;
use Modules\Registration\Exports\SpeakerRegistrationExport;
use Modules\Registration\Tables\SpeakerRegistrationTable;
use Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Base\Events\DeletedContentEvent;
use Carbon\Carbon;
use Assets;
use Excel;


class SpeakerRegistrationController extends Controller
{

  /**
   * Display a listing of the resource.
   * @return Response
   */
  public function index(SpeakerRegistrationTable $table)
  {
    page_title()->setTitle('Danh sách Speaker Registration');

    $table = $table->renderTable();

    return $table;
  }



  public function export()
  {
    return Excel::download(new SpeakerRegistrationExport, 'speaker_registration_' . Carbon::now() . '.xlsx');
  }


  /**
   * Remove the specified resource from storage.
   * @param int $id
   * @return Response
   */
  public function destroy(Request $request, $id)
  {
    $registration = SpeakerRegistration::find($id);
    $registration->delete();
    event(new DeletedContentEvent($request->all(), $registration));

    return Response::json(array(
      'success' => true
    ), 200);
  }

}
