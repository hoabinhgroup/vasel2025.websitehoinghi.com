<?php

namespace Modules\Slider\Forms;

use Modules\Base\Forms\FormAbstract;
use Modules\Slider\Entities\SliderItem;
use Modules\Slider\Http\Requests\SliderItemRequest;

class SliderItemForm extends FormAbstract
{
  protected $template = "base::forms.form-modal";

  public function buildForm()
  {
    $this->setupModel(new SliderItem())
      ->setValidatorClass(SliderItemRequest::class)
      ->withCustomFields()
      ->add("title", "text", [
        "label" => trans("base::form.title"),
        "label_attr" => ["class" => "control-label required"],
        "attr" => [
          "data-counter" => 200,
        ],
      ])
      ->add("link", "text", [
        "label" => trans("base::form.link"),
        "label_attr" => ["class" => "control-label required"],
        "attr" => [
          "placeholder" => "https://",
          "data-counter" => 150,
        ],
      ])
      ->add("description", "textarea", [
        "label" => trans("base::form.description"),
        "label_attr" => ["class" => "control-label"],
        "attr" => [
          "rows" => 4,
          "placeholder" => trans("base::form.description"),
          "data-counter" => 2000,
        ],
      ])
      ->add("order", "number", [
        "label" => trans("base::form.order"),
        "label_attr" => ["class" => "control-label"],
        "attr" => [
          "placeholder" => trans("base::forms.order_by_placeholder"),
        ],
        "default_value" => 0,
      ])
      ->add("image", "singleImage", [
        "label" => trans("base::form.image"),
        "label_attr" => ["class" => "control-label required"],
      ]);
  }
}
