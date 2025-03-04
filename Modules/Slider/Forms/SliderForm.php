<?php

namespace Modules\Slider\Forms;

use Modules\Base\Forms\FormAbstract;
use Modules\Slider\Entities\Slider;
use Modules\Slider\Http\Requests\SliderRequest;
use Modules\Slider\Tables\SliderItemTable;

class SliderForm extends FormAbstract
{
  public function buildForm()
  {
    $form = $this->setupModel(new Slider())
      ->setValidatorClass(SliderRequest::class)
      ->withCustomFields()
      ->add("name", "text", [
        "label" => trans("base::form.title"),
        "label_attr" => ["class" => "control-label required"],
        "attr" => [
          "data-counter" => 120,
        ],
      ])
      ->add("key", "text", [
        "label" => __("Key"),
        "label_attr" => ["class" => "control-label required"],
        "attr" => [
          "data-counter" => 120,
        ],
      ])
      ->add("description", "textarea", [
        "label" => trans("base::form.description"),
        "label_attr" => ["class" => "control-label"],
        "attr" => [
          "rows" => 4,
          "placeholder" => trans("base::form.description"),
          "data-counter" => 400,
        ],
      ])
      ->add("status", "onOff", [
        "label" => __("base::form.status"),
        "label_attr" => ["class" => "control-label"],
        "default_value" => old("status", $this->getModel()->status) ?? true,
      ]);

    if (!empty($this->getModel()->getAttributes())) {
      $form->addMetaBoxes([
        "slider-items" => [
          "title" => __("Slide Items"),
          "content" => app(\Modules\Slider\Tables\SliderItemTable::class)
            ->setAjaxUrl(
              route(
                "slider-item.index",
                ['sliderId' => $this->getModel()->id ? $this->getModel()->id : 0]
              )
            )
            ->renderTable(),
        ],
      ]);
    }
    $form->setBreakFieldPoint("status");
  }
}
