<?php

namespace Modules\Menu\Http\Controllers;

use DataTables;
use Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Routing\Controller;
use Modules\Menu\Tables\MenusTable;
use Modules\Menu\Repositories\MenusInterface;
use Modules\Base\Events\CreatedContentEvent;
use Modules\Base\Events\UpdatedContentEvent;
use Modules\Base\Http\Responses\BaseHttpResponse;
use Modules\Base\Traits\HasDeleteManyItemsTrait;
use Modules\Base\Forms\FormBuilder;
use Modules\Menu\Forms\MenusForm;
use Template;

class MenusController extends Controller
{
  use HasDeleteManyItemsTrait;
  /**
   * @var MenusInterface
   */
  protected $menus;

  public function __construct(MenusInterface $menus)
  {
    $this->menus = $menus;
  }

  /**
   * Display a listing of the resource.
   * @return Response
   */
  public function index(MenusTable $table)
  {
    page_title()->setTitle(__("menu::categories.list"));
    return $table->renderTable();
  }

  /**
   * Show the form for creating a new resource.
   * @return Response
   */
  public function create(FormBuilder $formBuilder)
  {
    page_title()->setTitle(__("menu::categories.add"));
    return $formBuilder->create(MenusForm::class)->renderForm();
  }

  /**
   * Store a newly created resource in storage.
   * @param Request $request
   * @return Response
   */
  public function store(Request $request, BaseHttpResponse $response)
  {
    // return Response::json($request->all());
    $request->merge(["status" => $request->has("status") ? 1 : 0]);
    $menu = $this->menus->create($request->all());

    if ($menu) {
      event(new CreatedContentEvent($request->all(), $menu));

      return $response
        ->setPreviousUrl(route("menus.index"))
        ->setNextUrl(route("menus.edit", $menu->id))
        ->setMessage(__("base::form-validate.add-success"));
    }
  }

  /**
   * Show the specified resource.
   * @param int $id
   * @return Response
   */
  public function show($id)
  {
    return view("menu::show");
  }

  /**
   * Show the form for editing the specified resource.
   * @param int $id
   * @return Response
   */
  public function edit($id, FormBuilder $formBuilder, Request $request)
  {
    $subject = $this->menus->find($id);

    page_title()->setTitle(__("menu::categories.edit"));

    return $formBuilder
      ->create(MenusForm::class, ["model" => $subject])
      ->renderForm();
  }

  /**
   * Update the specified resource in storage.
   * @param Request $request
   * @param int $id
   * @return Response
   */
  public function update(Request $request, $id)
  {
    if ($request->ajax()) {
      $request->merge(["status" => $request->has("status") ? 1 : 0]);
      $menu = $this->menus->update($id, $request->all());
      if ($menu) {
        event(new UpdatedContentEvent($request->all(), $menu));

        return $response
          ->setPreviousUrl(route("menus.index"))
          ->setMessage(__("base::form-validate.add-success"));
      }
    }
  }

  /**
   * Remove the specified resource from storage.
   * @param int $id
   * @return Response
   */
  public function destroy(Request $request, $id)
  {
    $this->menus->delete($request->id);

    return Response::json(
      [
        "success" => $request->id,
      ],
      200
    );
  }

  public function deletes(Request $request, BaseHttpResponse $response)
  {
    return $this->executeDeleteItems($request, $response, $this->menus);
  }
}
