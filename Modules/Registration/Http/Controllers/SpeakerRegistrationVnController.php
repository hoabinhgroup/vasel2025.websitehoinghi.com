<?php

namespace Modules\Registration\Http\Controllers;

use Auth;
use Modules\Base\Http\Responses\BaseHttpResponse;
use Modules\Registration\Entities\SpeakerRegistrationVn;
use Modules\Registration\Exports\SpeakerRegistrationVnExport;
use Modules\Registration\Tables\SpeakerRegistrationVnTable;
use Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Base\Events\DeletedContentEvent;
use Modules\Registration\Tables\SubscribeTable;
use Modules\Registration\Exports\RegistrationExport;
use Carbon\Carbon;
use Assets;
use Excel;


class SpeakerRegistrationVnController extends Controller
{

  /**
   * Display a listing of the resource.
   * @return Response
   */
  public function index(SpeakerRegistrationVnTable $table)
  {
    page_title()->setTitle('Danh sách Speaker Registration Vn');

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
    return Excel::download(new SpeakerRegistrationVnExport, 'speaker_registration_vn_' . Carbon::now() . '.xlsx');
  }


  /**
   * Remove the specified resource from storage.
   * @param int $id
   * @return Response
   */
  public function destroy(Request $request, $id)
  {
    $registration = SpeakerRegistrationVn::find($id);
    $registration->delete();
    event(new DeletedContentEvent($request->all(), $registration));

    return Response::json(array(
      'success' => true
    ), 200);
  }

}
