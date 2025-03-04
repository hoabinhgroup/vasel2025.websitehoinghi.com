<?php

namespace Modules\Page\Forms;

use Modules\Base\Enums\BaseStatusEnum;
use Modules\Base\Forms\FormAbstract;
use Modules\Page\Entities\Page;
use Modules\Page\Http\Requests\PageRequest;

class PageForm extends FormAbstract
{
  public function buildForm()
  {
    if ($this->getModel()) {
      //dd($this->model['template']);
      $template = $this->model->template;
    }
    $this->setupModel(new Page())
      ->setValidatorClass(PageRequest::class)
      ->withCustomFields()
      // ->addCustomField('tags', TagField::class)
      ->add("name", "text", [
        "label" => __("base::form.title"),
        "label_attr" => ["class" => "control-label required"],
        "attr" => [
          "placeholder" => __("base::form.name_placeholder"),
          // "onkeyup" => "ChangeToSlug()",
        ],
      ])
      // ->add("slug", "text", [
      //   "label" => __("base::form.slug"),
      //   "label_attr" => ["class" => "control-label required"],
      //   "attr" => [
      //     "placeholder" => __("base::form.slug_placeholder"),
      //   ],
      // ])
      ->add("content", "editor", [
        "label" => __("base::form.content"),
        "label_attr" => ["class" => "control-label required"],
        "attr" => [
          "rows" => 4,
          "class" => "tinymce editor-tinymce form-control",
          "shortcode" => true,
          "placeholder" => __("base::form.description_placeholder"),
        ],
      ])
      ->add("status", "select", [
        "label" => trans("base::form.status"),
        "label_attr" => ["class" => "control-label required"],
        "choices" => BaseStatusEnum::labels(),
      ])
      ->add("template", "select", [
        "label" => "Template",
        "label_attr" => ["class" => "control-label"],
        "attr" => [
          "class" => "form-control",
        ],
        "choices" => ["0" => "Default"] + \Template::select(["name"]),
        "value" => old("template", $template ?? 0),
      ])
      ->add("image", "singleImage", [
        "label" => __("base::form.cover"),
        "label_attr" => ["class" => "control-label"],
      ])
      ->setBreakFieldPoint("status");
  }
}
