<?php

namespace Modules\Block\Forms;

use Modules\Base\Enums\BaseStatusEnum;
use Modules\Base\Forms\FormAbstract;
use Modules\Block\Entities\Block;
use Modules\Block\Http\Requests\BlockRequest;

class BlockForm extends FormAbstract
{
  public function buildForm()
  {
    $this->setupModel(new Block())
      ->setValidatorClass(BlockRequest::class)
      ->withCustomFields()
      ->add("name", "text", [
        "label" => __("base::form.title"),
        "label_attr" => ["class" => "control-label required"],
        "attr" => [
          "placeholder" => __("base::form.name_placeholder"),
        ],
      ])
      ->add("alias", "text", [
        "label" => trans("block::block.alias"),
        "label_attr" => ["class" => "control-label required"],
        "attr" => [
          "placeholder" => trans("block::block.alias_placeholder"),
          "data-counter" => 120,
        ],
      ])
      ->add("description", "textarea", [
        "label" => trans("base::form.description"),
        "label_attr" => ["class" => "control-label"],
        "attr" => [
          "rows" => 4,
          "placeholder" => trans("base::form.description_placeholder"),
          "data-counter" => 400,
        ],
      ])
      ->add("content", "editor", [
        "label" => trans("base::form.content"),
        "label_attr" => ["class" => "control-label"],
        "attr" => [
          "rows" => 4,
          "class" => "tinymce editor-tinymce",
          "placeholder" => trans("base::form.description_placeholder"),
        ],
      ])
      ->add("status", "select", [
        "label" => trans("base::form.status"),
        "label_attr" => ["class" => "control-label required"],
        "choices" => BaseStatusEnum::labels(),
      ])
      ->setBreakFieldPoint("status");
  }
}
