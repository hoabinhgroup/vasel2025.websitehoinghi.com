<?php

namespace Modules\Post\Forms;

use Modules\Base\Enums\BaseStatusEnum;
use Modules\Base\Forms\FormAbstract;
use Modules\Post\Entities\Categories;
use Modules\Post\Http\Requests\CategoriesRequest;

class CategoriesForm extends FormAbstract
{
  public function buildForm()
  {
    if ($this->getModel()) {
      $parent = $this->model->parent;
      $key = $this->model->key;
    }
    $this->setupModel(new Categories())
      ->setValidatorClass(CategoriesRequest::class)
      ->withCustomFields()
      // ->addCustomField('tags', TagField::class)
      ->add("name", "text", [
        "label" => __("base::form.title"),
        "label_attr" => ["class" => "control-label required"],
        "attr" => [
          "placeholder" => __("base::form.name_placeholder")
        ],
      ])
      ->add("description", "editor", [
        "label" => __("base::form.content"),
        "label_attr" => ["class" => "control-label required"],
        "attr" => [
          "rows" => 4,
          "class" => 'tinymce',
          "placeholder" => __("base::form.description_placeholder"),
        ],
      ])
      ->add("status", "select", [
          "label" => trans("base::form.status"),
          "label_attr" => ["class" => "control-label required"],
          "choices" => BaseStatusEnum::labels(),
      ])
      ->add("parent", "recursiveSelect", [
        "label" => __("base::form.categories"),
        "label_attr" => ["class" => "control-label required"],
        "attr" => [
          "class" => "chosen-select form-control select-search-full",
        ],
        "choices" => \Categories::recursive(),
        "value" => old("parent", $parent ?? 0),
      ])
      ->add("image", "mediaImage", [
        "label" => __("base::form.cover"),
        "label_attr" => ["class" => "control-label"],
      ])
      ->setBreakFieldPoint("status");
  }
}
