<?php

namespace Modules\Post\Forms;

use Modules\Base\Enums\BaseStatusEnum;
use Modules\Post\Repositories\PostCategoriesInterface;
use Modules\Base\Forms\Fields\TagField;
use Modules\Base\Forms\FormAbstract;
use Modules\Post\Entities\Post;
use Modules\Post\Http\Requests\PostRequest;
use Categories;

class PostForm extends FormAbstract
{
  public function buildForm()
  {
    $selectedCategories = [];
    $tags = null;
    if ($this->getModel()) {
        $content = $this->getModel()->content;
      $tags = $this->getModel()
        ->tags()
        ->pluck("name")
        ->all();
      $tags = implode(",", $tags);

      $selectedCategories = app(PostCategoriesInterface::class)
        ->getByAttributes([], ["post_id" => $this->getModel()["id"]])
        ->toArray();
    }

    if (!empty($selectedCategories)) {
      foreach ($selectedCategories as $item):
        $selectedCategories[] = $item["category_id"];
      endforeach;
    }

    $this->setupModel(new Post())
      ->setValidatorClass(PostRequest::class)
      ->withCustomFields()
      ->addCustomField("tags", TagField::class)
      ->add("name", "text", [
        "label" => __("base::form.title"),
        "label_attr" => ["class" => "control-label required"],
        "attr" => [
          "placeholder" => __("base::form.name_placeholder"),
        ],
      ])
      ->add("description", "textarea", [
        "label" => __("base::form.description"),
        "label_attr" => ["class" => "control-label required"],
        "attr" => [
          "rows" => 4,
          "class" => "form-control",
          "placeholder" => __("base::form.description_placeholder"),
        ],
      ])
      ->add("content", "editor", [
        "label" => __("base::form.content"),
        "label_attr" => ["class" => "control-label tinymce required"],
        "attr" => [
          "rows" => 4,
          "class" => "tinymce editor-tinymce form-control",
          "placeholder" => __("base::form.description_placeholder")
        ],
      ])
      ->add("status", "select", [
        "label" => trans("base::form.status"),
        "label_attr" => ["class" => "control-label required"],
        "choices" => BaseStatusEnum::labels(),
      ])
      ->add("categories[]", "categoryMulti", [
        "label" => trans("base::form.categories"),
        "label_attr" => ["class" => "control-label required"],
        "choices" => Categories::recursive(),
        "value" => $selectedCategories,
      ])
      ->add("image", "singleImage", [
        "label" => __("base::form.cover"),
        "label_attr" => ["class" => "control-label"],
      ])
      ->add("tag", "tags", [
        "label" => __("base::form.tags"),
        "label_attr" => ["class" => "control-label"],
        "value" => $tags,
        "attr" => [
          "placeholder" => __("Write some tags"),
          "data-url" => route("tag.getAllTags"),
        ],
      ])
      ->setBreakFieldPoint("status");
  }
}
