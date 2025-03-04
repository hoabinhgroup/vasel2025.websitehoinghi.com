<?php

namespace Modules\Api\Http\Controllers\Api;

use Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Acl\Entities\Users;
use Modules\Api\Repositories\ApiInterface;
use Modules\Api\Entities\Api;
use Carbon\Carbon;
use Assets;


class BillInfoController extends Controller
{

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
    public function index()
    {
	    return response()->json($this->api->all());
    }


}
