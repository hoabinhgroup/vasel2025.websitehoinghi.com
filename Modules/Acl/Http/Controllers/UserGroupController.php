<?php

namespace Modules\Acl\Http\Controllers;

use DataTables;
use Illuminate\Http\Request;
use Response;
use Module;
use Modules\Acl\Repositories\UserGroupInterface;
use Modules\Acl\Tables\UserGroupTable;
use Illuminate\Routing\Controller;
use Modules\Acl\Entities\Roles;
use Modules\Acl\Entities\UserGroupRoles;
use Modules\Base\Http\Responses\BaseHttpResponse;
use Modules\Base\Forms\FormBuilder;
use Modules\Acl\Forms\UserGroupForm;

class UserGroupController extends Controller
{
  protected $userGroup;

  public function __construct(UserGroupInterface $userGroup)
  {
    $this->userGroup = $userGroup;
  }
  /**
   * Display a listing of the resource.
   * @return Response
   */
  public function index(UserGroupTable $table)
  {
    return $table->renderTable();
  }

  /**
   * Show the form for creating a new resource.
   * @return Response
   */
  public function create(FormBuilder $formBuilder)
  {
    page_title()->setTitle(__("acl::user-group.add"));
    return $formBuilder->create(UserGroupForm::class)->renderForm();
  }

  /**
   * Store a newly created resource in storage.
   * @param Request $request
   * @return Response
   */
  public function store(Request $request, BaseHttpResponse $response)
  {
    $userGroup = $this->userGroup->create($request->all());

    return $response
      ->setPreviousUrl(route("user-group.index"))
      ->setNextUrl(route("user.edit", $userGroup->id))
      ->setMessage(__("base::form-validate.add-success"));
  }

  /**
   * Show the specified resource.
   * @param int $id
   * @return Response
   */
  public function permission($id)
  {
    $modules = Module::getOrdered();

    $userGroup = $this->userGroup->find($id);

    return view("acl::cmspanel.user-group.permission", [
      "modules" => $modules,
      "id" => $id,
      "userGroup" => $userGroup,
    ]);
  }

  public function setRole(Request $request)
  {
    if ($request->ajax()) {
      $list = [];

      foreach ($request->role as $role):
        $param = explode("::", $role);
        //$list[$param[1]][$param[0]] = true;
        $list[$param[0]] = [$param[0] => true];
      endforeach;
      //return Response::json($list);
      // create or update table role
      foreach ($list as $key => $item):
        $roles = Roles::updateOrCreate(
          ["name" => $key],
          [
            "permissions" => $item,
            "slug" => $key,
            "name" => $key,
          ]
        );

        UserGroupRoles::updateOrCreate([
          "group_id" => $request->id_group,
          "role_id" => $roles->id,
        ]);
      endforeach;

      // add quyền cho nhóm
      return Response::json(["success" => true], 200);
    }
  }

  /**
   * Show the form for editing the specified resource.
   * @param int $id
   * @return Response
   */
  public function edit($id, FormBuilder $formBuilder, Request $request)
  {
    $user = $this->userGroup->find($id);
    page_title()->setTitle(__("acl::user-group.edit"));

    return $formBuilder
      ->create(UserGroupForm::class, ["model" => $user])
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
    $userGroup = $this->userGroup->update($id, $request->all());

    if ($userGroup) {
      return $response
        ->setPreviousUrl(route("user-group.index"))
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
    $this->userGroup->delete($id);

    return Response::json(
      [
        "success" => true,
      ],
      200
    );
  }
}
