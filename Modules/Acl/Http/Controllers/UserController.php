<?php

namespace Modules\Acl\Http\Controllers;

use Validator;
use Redirect;
use Session;
use Illuminate\Http\Request;
use Response;
use Auth;
use Modules\Base\Events\CreatedContentEvent;
use Illuminate\Support\Facades\File;
use Modules\Acl\Repositories\UserInterface;
use Modules\Acl\Repositories\UserGroupInterface;
use Modules\Acl\Tables\UserTable;
use Modules\Base\Http\Responses\BaseHttpResponse;
use Modules\Base\Forms\FormBuilder;
use Modules\Acl\Forms\UserForm;
use Modules\Acl\Forms\ProfileForm;
use Modules\Acl\Forms\PasswordForm;
use Modules\Acl\Http\Requests\UpdatePasswordRequest;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Modules\Base\Http\Requests\LoginRequest;
use Carbon\Carbon;
use Exception;
use Modules\Base\Events\UpdatedContentEvent;
use Slim;

class UserController extends Controller
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
    return $table->renderTable();
  }

  /**
   * Show the form for creating a new resource.
   * @return Response
   */
  public function create(FormBuilder $formBuilder)
  {
    page_title()->setTitle(__("acl::user.add"));
    return $formBuilder->create(UserForm::class)->renderForm();
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
    if ($user) {
      event(new CreatedContentEvent($request->all(), $user));
    }
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

  public function changePassword($id, Request $request)
  {

    if ($request->ajax()) {
      $password = $request->password;
      $password_confirm = $request->password_confirmation;
      if ($password == $password_confirm) {
        $this->user->update($id, ["password" => Hash::make($password)]);
        $user = $this->user->find($id);
        event(new UpdatedContentEvent($request->all(), $user));
        return Response::json(["success" => true]);
      }
    } else {
      return view("acl::cmspanel.user.change-password", compact("id"));
    }
  }

  public function changePasswordProfile($id, UpdatePasswordRequest $request, BaseHttpResponse $response)
  {
    $request->merge(['id' => $id]);
    $user = $this->user->findOrFail($id);

    if (!Hash::check($request->input('old_password'), $user->password)) {
      return $response
        ->setError()
        ->setMessage(trans('acl::user.current_password_not_valid'));
    }


    $user->password = Hash::make($request->input('password'));

    $this->user->update($id, $user->toArray());
    event(new UpdatedContentEvent($request->all(), $user));

    if ($user->id != auth()->user()->id) {
      Auth::setUser($user)->logoutOtherDevices($request->input('password'));
    }

    $result = do_action(USER_ACTION_AFTER_UPDATE_PASSWORD, $request, $user);

    if ($result instanceof Exception) {
      return $response
        ->setError()
        ->setMessage($result->getMessage());
    }

    return $response->setMessage(trans('acl::user.password_update_success'));
  }

  public function changeAvatarProfile($id, BaseHttpResponse $response)
  {
    $images = Slim::getImages();
    if (!empty($images)) {
      $image = $images[0];
      $name = $image["output"]["name"];
      $data = $image["output"]["data"];

      $this->deleteItemIfExist($id, $name);
      // store the file
      $file = Slim::saveFile(
        $data,
        $name,
        public_path("uploads/avatar/" . $id . "/"),
        false
      );
      $result = $this->user->update($id, ["profile_image" => $name]);

      if ($result) {
        return $response
          ->setPreviousUrl(route("user.index"))
          ->setMessage(__("base::form-validate.update-success"));
      }
    }
  }

  public function deleteItemIfExist($id, $name)
  {
    $file_path = public_path("uploads/avatar/" . $id . "/" . $name);
    if (File::exists($file_path)) {
      File::delete($file_path);
    }
    return true;
  }

  public function deleteAvatarProfile($id, Request $request)
  {
    $name = $request->name;
    $id = $request->id;
    if (
      auth()->user()->id == $id
    ) {
      //Xóa ảnh
      $this->deleteItemIfExist($id, $name);
      // Cập nhật db
      $this->user->update($id, ["profile_image" => ""]);
    }

    return response()->json($request->all());
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
      return view("base::cmspanel.dashboard.index");
    } else {
      return view("base::cmspanel.auth.login");
    }
  }

  public function postLogin(LoginRequest $request)
  {
    //login code or email

    $login = $request->email;
    $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? "email" : "code";
    request()->merge([$field => $login]);

    $auth = [
      $field => $login,
      "password" => $request->password,
    ];


    $remember = $request->remember;
    if (!empty($remember)) {
      $remember = true;
    } else {
      $remember = false;
    }



    if (Auth::attempt($auth, $remember)) {

      // Cookie::queue("visit_welcome", 12222, 5);
      $akey = md5($request->password . randomString());
      // setValueStored("akey", $akey, 14400);
      Session::put("akey", $akey);
      Auth::user()->last_login = Carbon::now();
      Auth::user()->save();


      // return redirect('cmspanel/dashboard');
      return redirect(session('dash_board_link') ??  BACKEND . '/dashboard');
      //return Redirect::intended('/cmspanel');
    } else {
      //return redirect('auth/login');
      return redirect()
        ->back()
        ->withErrors(["Tài khoản không đúng"]);
    }

    /* $auth = \App\Users::where([
		 	'email' => $request->email,
		 	'password' => md5($request->password)
		  ])->first();


	     if ($auth) {
        echo "Đăng nhập thành công";
    }else{

   		echo "Đăng nhập thất bại";

   		}*/
  }

  public function editUserProfile(Request $request, FormBuilder $formBuilder)
  {
    page_title()->setTitle("Sửa thông tin cá nhân");
    if (!Auth::user()) {
      abort(404);
    }
    $user = Auth::user();
    $form = $formBuilder
      ->create(ProfileForm::class, ['model' => $user])
      ->setUrl(route('user.update.own.profile', $user->id));

    $passwordForm = $formBuilder
      ->create(PasswordForm::class)
      ->setUrl(route('user.changePasswordProfile', $user->id));

    $form = $form->renderForm();
    $passwordForm = $passwordForm->renderForm();

    return view("acl::cmspanel.user.edit-user", compact('user', 'form', 'passwordForm'));
  }

  public function updateUserProfile(
    Request $request,
    BaseHttpResponse $response
  ) {
    if (!Auth::user()) {
      abort(404);
    }
    $user = $this->user->update(Auth::user()->id, $request->all());
    if ($user) {
      return $response
        ->setPreviousUrl(back())
        ->setMessage(__("base::form-validate.update-success"));
    }
  }

  public function logout()
  {
    // deleteValueStored("akey");
    if (Auth::check()) {
      Auth::logout();
      session()->flush();
      return redirect(BACKEND);
    }
  }
}
