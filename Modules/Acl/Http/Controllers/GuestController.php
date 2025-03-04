<?php

namespace Modules\Acl\Http\Controllers;

use Validator;
use App\User;
use Redirect;
use Session;
use Illuminate\Http\Request;
use Response;
use Auth;
use Modules\Acl\Repositories\UserInterface;
use Modules\Acl\Repositories\UserGroupInterface;
use Modules\Acl\Tables\UserTable;
use Modules\Base\Http\Responses\BaseHttpResponse;
use Modules\Base\Forms\FormBuilder;
use Modules\Acl\Http\Requests\GuestRegisterRequest;
use Modules\Acl\Forms\UserForm;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Modules\Base\Http\Requests\LoginRequest;

class GuestController extends Controller
{
  /**
   * @var UserInterface
   */
  protected $user;

  /**
   * @var UserGroupInterface
   */

  protected $userGroup;

  public function __construct(
    UserInterface $user,
    UserGroupInterface $userGroup
  ) {
    $this->user = $user;
    $this->userGroup = $userGroup;
  }
  /**
   * Display a listing of the resource.
   * @return Response
   */
  public function index(UserTable $table)
  {
    page_title()->setTitle(__("acl::user.list"));
  }

  /**
   * Show the form for creating a new resource.
   * @return Response
   */
  public function create(FormBuilder $formBuilder)
  {
  }

  /**
   * Store a newly created resource in storage.
   * @param Request $request
   * @return Response
   */
  public function store(Request $request, BaseHttpResponse $response)
  {
    $request->merge(["status" => $request->has("status") ? 1 : 0]);
    $request->merge(["is_admin" => $request->id_group == 1 ? 1 : 0]);
    $user = $this->user->create($request->all());

    return $response
      ->setPreviousUrl(route("user.index"))
      ->setNextUrl(route("user.edit", $user->id))
      ->setMessage(__("base::form-validate.add-success"));
  }

  /**
   * Show the form for editing the specified resource.
   * @param int $id
   * @return Response
   */
  public function edit($id, FormBuilder $formBuilder, Request $request)
  {
    $user = $this->user->find($id);
    page_title()->setTitle(__("acl::user.edit"));

    return $formBuilder
      ->create(UserForm::class, ["model" => $user])
      ->renderForm();
  }

  /**
   * Update the specified resource in storage.
   * @param Request $request
   * @param int $id
   * @return Response
   */
  public function update(Request $request, $id, BaseHttpResponse $response)
  {
    $request->merge(["status" => $request->has("status") ? 1 : 0]);
    $request->merge(["is_admin" => $request->id_group == 1 ? 1 : 0]);
    $user = $this->user->update($id, $request->all());
    if ($user) {
      return $response
        ->setPreviousUrl(route("user.index"))
        ->setMessage(__("base::form-validate.update-success"));
    }
  }

  /**
   * Remove the specified resource from storage.
   * @param int $id
   * @return Response
   */
  public function destroy($id)
  {
    //
  }

  public function getLogin()
  {
    if (Auth::check()) {
      return view(\Theme::current() . "::index");
    } else {
      if (session("link")) {
        $myPath = session("link");
        $loginPath = url("/login");
        $previous = url()->previous();

        if ($previous = $loginPath) {
          session(["link" => $myPath]);
        } else {
          session(["link" => $previous]);
        }
      } else {
        session(["link" => url()->previous()]);
      }

      return view(\Theme::current() . "::login");
    }
  }

  public function getRegister()
  {
    if (Auth::check()) {
      return view(\Theme::current() . "::index");
    } else {
      return view(\Theme::current() . "::register");
    }
  }

  public function postLogin(LoginRequest $request)
  {
    $auth = [
      "email" => $request->email,
      "password" => $request->password,
    ];

    $remember = $request->remember;
    if (!empty($remember)) {
      $remember = true;
    } else {
      $remember = false;
    }

    if (Auth::attempt($auth, $remember)) {
      return Redirect::intended(session("link"));
    } else {
      //return redirect('auth/login');
      return redirect()
        ->back()
        ->withErrors(["Tài khoản không đúng"]);
    }
  }

  public function postRegister(GuestRegisterRequest $request)
  {
    User::create([
      "name" => $request->name,
      "email" => $request->email,
      "password" => Hash::make($request->password),
      "is_admin" => 0,
      "id_group" => 0,
    ]);

    return Redirect::intended(session("link"));
  }

  public function logout()
  {
    if (Auth::check()) {
      Auth::logout();
      return redirect("/");
    }
  }
}
