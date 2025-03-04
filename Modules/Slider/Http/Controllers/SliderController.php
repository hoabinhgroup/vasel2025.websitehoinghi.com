<?php

namespace Modules\Slider\Http\Controllers;

use Auth;
use Modules\Base\Http\Responses\BaseHttpResponse;
use Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Acl\Entities\Users;
use Modules\Slider\Repositories\SliderInterface;
use Modules\Base\Events\CreatedContentEvent;
use Modules\Base\Events\UpdatedContentEvent;
use Modules\Base\Events\DeletedContentEvent;
use Modules\Slider\Entities\Slider;
use Modules\Slider\Tables\SliderTable;
use Modules\Base\Forms\FormBuilder;
use Modules\Slider\Forms\SliderForm;
use Carbon\Carbon;
use Assets;

class SliderController extends Controller
{
  /**
   * @var SliderInterface
   */
  protected $slider;

  public function __construct(SliderInterface $slider)
  {
    $this->slider = $slider;
  }

  /**
   * Display a listing of the resource.
   * @return Response
   */
  public function index(SliderTable $table)
  {
    page_title()->setTitle(__("slider::slider.list"));

    return $table->renderTable();
  }

  /**
   * Show the form for creating a new resource.
   * @return Response
   */
  public function create(FormBuilder $formBuilder)
  {
    page_title()->setTitle(__("slider::slider.add"));
    return $formBuilder->create(SliderForm::class)->renderForm();
  }

  /**
   * Store a newly created resource in storage.
   * @param Request $request
   * @return Response
   */
  public function store(Request $request, BaseHttpResponse $response)
  {
    $request->merge(["status" => $request->has("status") ? 1 : 0]);
    $slider = $this->slider->create($request->all());

    event(new CreatedContentEvent($request->all(), $slider));

    return $response
      ->setPreviousUrl(route("slider.index"))
      ->setNextUrl(route("slider.edit", $slider->id))
      ->setMessage(__("base::form-validate.add-success"));
  }

  /**
   * Show the specified resource.
   * @param int $id
   * @return Response
   */
  public function show($id)
  {
    return view("slider::show");
  }

  /**
   * Show the form for editing the specified resource.
   * @param int $id
   * @return Response
   */
  public function edit($id, FormBuilder $formBuilder, Request $request)
  {
    $subject = $this->slider->find($id);

    page_title()->setTitle(__("slider::slider.edit"));

    return $formBuilder
      ->create(SliderForm::class, ["model" => $subject])
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

    $slider = $this->slider->update($id, $request->all());

    if ($slider) {
      event(new UpdatedContentEvent($request->all(), $slider));
      return $response
        ->setPreviousUrl(route("slider.index"))
        ->setMessage(__("base::form-validate.update-success"));
    }
  }

  public function restore(Request $request, BaseHttpResponse $response)
  {
    $slider = $this->slider->getFirstByWithTrash([
      "sliders.id" => $request->id,
    ]);
    $this->slider->restoreBy(["id" => $request->id]);
    event(new DeletedContentEvent($request->all(), $slider, "restore"));

    return $response
      ->setPreviousUrl(route("slider.index"))
      ->setMessage(__("base::form-validate.update-success"));
  }
  /**
   * Remove the specified resource from storage.
   * @param int $id
   * @return Response
   */
  public function destroy(Request $request, $id)
  {
    $slider = $this->slider->find($id);
    $this->slider->delete($id);
    event(new DeletedContentEvent($request->all(), $slider));

    return Response::json(
      [
        "success" => true,
      ],
      200
    );
  }
}
