<?php

namespace Modules\Slider\Http\Controllers\Api;

use Modules\Base\Http\Responses\BaseHttpResponse;
use Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Acl\Entities\Users;
use Modules\Slider\Repositories\SliderItemInterface;
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
  public function index(FormBuilder $formBuilder)
  {
    return $formBuilder
      ->create(SliderItemForm::class, [
        "method" => "POST",
        "url" => route("slider-item.create.store"),
      ])
      ->add("slider_id", "hidden", [
        "value" => request()->id,
      ])
      ->renderForm();
  }

  public function edit($id, FormBuilder $formBuilder)
  {
    $subject = $this->sliderItem->find($id);

    page_title()->setTitle(__("slider-item::slider.edit"));

    return $formBuilder
      ->create(SliderItemForm::class, [
        "model" => $subject,
        "method" => "POST",
        "url" => route("slider-item.edit", $id),
      ])
      ->add("slider_id", "hidden", [
        "value" => $subject->slider_id,
      ])
      ->renderForm();
  }

  public function sort(Request $request)
  {
    $data = $request->all();
    $data = $data["data"];
    if (!empty($data)) {
      foreach ($data as $item):
        $this->sliderItem->update($item["id"], ["order" => $item["order"]]);
      endforeach;
    }

    return Response::json([
      "success" => true,
      "message" => "Cập nhật thứ tự thành công",
    ]);
  }
}
