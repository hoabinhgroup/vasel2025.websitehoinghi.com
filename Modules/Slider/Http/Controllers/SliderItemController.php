<?php

namespace Modules\Slider\Http\Controllers;

use Auth;
use Modules\Base\Http\Responses\BaseHttpResponse;
use Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Acl\Entities\Users;
use Modules\Slider\Repositories\SliderItemInterface;
use Modules\Base\Events\CreatedContentEvent;
use Modules\Base\Events\UpdatedContentEvent;
use Modules\Base\Events\DeletedContentEvent;
use Modules\Slider\Entities\SliderItem;
use Modules\Slider\Tables\SliderItemTable;
use Modules\Base\Forms\FormBuilder;
use Modules\Slider\Forms\SliderItemForm;
use Carbon\Carbon;
use Assets;

class SliderItemController extends Controller
{
  /**
   * @var SliderInterface
   */
  protected $sliderItem;

  public function __construct(SliderItemInterface $sliderItem)
  {
    $this->sliderItem = $sliderItem;
  }

  /**
   * Display a listing of the resource.
   * @return Response
   */
  public function index(SliderItemTable $table)
  {
    page_title()->setTitle(__("slider-item::slider.list"));
    return $table
            ->setOption("id", "table_1")
            ->renderTable();
  }

  /**
   * Show the form for creating a new resource.
   * @return Response
   */
  public function create(FormBuilder $formBuilder)
  {
    page_title()->setTitle(__("slider-item::slider.add"));

    return $formBuilder->create(SliderItemForm::class)->renderForm();
  }

  /**
   * Store a newly created resource in storage.
   * @param Request $request
   * @return Response
   */
  public function store(Request $request, BaseHttpResponse $response)
  {
    $request->merge([
      "slider_id" => $request->has("slider_id") ? $request->slider_id : 0,
    ]);
    $slider = $this->sliderItem->create($request->all());

    event(new CreatedContentEvent($request->all(), $slider));

    return $response
      // ->setPreviousUrl(route("slider-item.index", $request->slider_id))
      ->setMessage(__("base::form-validate.add-success"));
  }

  /**
   * Show the form for editing the specified resource.
   * @param int $id
   * @return Response
   */
  public function edit($id, FormBuilder $formBuilder, Request $request)
  {
    $subject = $this->sliderItem->find($id);

    page_title()->setTitle(__("slider-item::slider.edit"));

    return $formBuilder
      ->create(SliderItemForm::class, ["model" => $subject])
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
    $request->merge([
      "slider_id" => $request->has("slider_id") ? $request->slider_id : 0,
    ]);

    $slider = $this->sliderItem->update($id, $request->all());

    if ($slider) {
      event(new UpdatedContentEvent($request->all(), $slider));
      return $response
        //->setPreviousUrl(route("slider-item.index"))
        ->setMessage(__("base::form-validate.update-success"));
    }
  }

  /**
   * Remove the specified resource from storage.
   * @param int $id
   * @return Response
   */
  public function destroy(Request $request, $id)
  {
    $slider = $this->sliderItem->find($id);
    $this->sliderItem->delete($id);
    event(new DeletedContentEvent($request->all(), $slider));

    return Response::json(
      [
        "success" => true,
      ],
      200
    );
  }
}
