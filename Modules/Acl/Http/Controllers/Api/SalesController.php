<?php

namespace Modules\Acl\Http\Controllers\Api;

use Validator;
use Redirect;
use Session;
use Illuminate\Http\Request;
use Response;
use Auth;
use Modules\Acl\Repositories\UserInterface;
use Modules\Base\Http\Responses\BaseHttpResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;

class SalesController extends Controller
{
  /**
   * @var UserInterface
   */
  protected $user;

  /**
   * @var UserGroupInterface
   */

  public function __construct(UserInterface $user)
  {
    $this->user = $user;
  }
  /**
   * Display a listing of the resource.
   * @return Response
   */
  public function list()
  {
    return $this->user->all()->toArray();
  }
}
