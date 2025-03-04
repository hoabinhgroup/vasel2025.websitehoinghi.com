<?php

namespace Modules\Base\Forms;

use Assets;
use Exception;
use Illuminate\Support\Arr;
use Throwable;
use Modules\Base\Forms\Fields\AutocompleteField;
use Modules\Base\Forms\Fields\EditorField;
use Modules\Base\Forms\Fields\OnOffField;
use Modules\Base\Forms\Fields\MediaImageField;
use Modules\Base\Forms\Fields\SingleImageField;
use Modules\Base\Forms\Fields\CustomSelectField;
use Modules\Base\Forms\Fields\RecursiveSelectField;
use Modules\Base\Forms\Fields\CustomRadioField;
use Modules\Base\Forms\Fields\MultiCheckboxRecursiveField;
use Modules\Base\Forms\Fields\HtmlField;
use Modules\Base\Forms\Fields\DateTimeField;
use Modules\Base\Forms\Fields\TimeField;
use Kris\LaravelFormBuilder\Fields\FormField;
use Kris\LaravelFormBuilder\Form;
use JsValidator;

abstract class FormAbstract extends Form
{
  /**
   * @var array
   */
  protected $options = [];

  /**
   * @var string
   */
  protected $title = "";

  /**
   * @var string
   */
  protected $validatorClass = "";

  /**
   * @var array
   */
  protected $metaBoxes = [];

  /**
   * @var string
   */
  protected $actionButtons = "";

  /**
   * @var string
   */
  protected $breakFieldPoint = "";

  /**
   * @var bool
   */
  protected $useInlineJs = false;

  /**
   * @var string
   */
  protected $wrapperClass = "form-body";

  /**
   * @var string
   */
  protected $template = "base::forms.form";

  /**
   * FormAbstract constructor.
   */
  public function __construct()
  {
    $this->setMethod("POST");
    $this->setFormOption("template", $this->template);
    $this->setFormOption("id", "form_" . md5(get_class($this)));
  }

  /**
   * @return array
   */
  public function getOptions(): array
  {
    return $this->options;
  }

  /**
   * @param array $options
   * @return $this
   */
  public function setOptions(array $options): self
  {
    $this->options = $options;
    return $this;
  }

  /**
   * @return string
   */
  public function getTitle(): string
  {
    return $this->title;
  }

  /**
   * @param string $title
   * @return $this
   */
  public function setTitle($title): self
  {
    $this->title = $title;
    return $this;
  }

  /**
   * @return array
   */
  public function getMetaBoxes(): array
  {
    uasort($this->metaBoxes, function ($before, $after) {
      if (Arr::get($before, "priority", 0) > Arr::get($after, "priority", 0)) {
        return 1;
      } elseif (
        Arr::get($before, "priority", 0) < Arr::get($after, "priority", 0)
      ) {
        return -1;
      }

      return 0;
    });

    return $this->metaBoxes;
  }

  /**
   * @param string $name
   * @return string
   * @throws Throwable
   */
  public function getMetaBox($name): string
  {
    if (!Arr::get($this->metaBoxes, $name)) {
      return "";
    }

    $metaBox = $this->metaBoxes[$name];

    return view("base::forms.partials.meta-box", compact("metaBox"))->render();
  }

  /**
   * @param array $boxes
   * @return $this
   */
  public function addMetaBoxes($boxes): self
  {
    if (!is_array($boxes)) {
      $boxes = [$boxes];
    }
    $this->metaBoxes = array_merge($this->metaBoxes, $boxes);

    return $this;
  }

  /**
   * @param string $name
   * @return FormAbstract
   */
  public function removeMetaBox($name): self
  {
    Arr::forget($this->metaBoxes, $name);
    return $this;
  }

  /**
   * @return string
   * @throws Throwable
   */
  public function getActionButtons(): string
  {
    if ($this->actionButtons === "") {
      return view("base::elements.form-actions")->render();
    }

    return $this->actionButtons;
  }

  public function getSaveButton(): string
  {
    if ($this->actionButtons === "") {
      return view("base::elements.form-save")->render();
    }

    return $this->actionButtons;
  }

  public function getSaveWidget(): string
  {
    if ($this->actionButtons === "") {
      return view("base::elements.form-save-widget")->render();
    }

    return $this->actionButtons;
  }

  /**
   * @param string $actionButtons
   * @return $this
   */
  public function setActionButtons($actionButtons): self
  {
    $this->actionButtons = $actionButtons;
    return $this;
  }

  /**
   * @return $this
   */
  public function removeActionButtons(): self
  {
    $this->actionButtons = "";
    return $this;
  }

  /**
   * @return string
   */
  public function getBreakFieldPoint(): string
  {
    return $this->breakFieldPoint;
  }

  /**
   * @param string $breakFieldPoint
   * @return $this
   */
  public function setBreakFieldPoint(string $breakFieldPoint): self
  {
    $this->breakFieldPoint = $breakFieldPoint;
    return $this;
  }

  /**
   * @return bool
   */
  public function isUseInlineJs(): bool
  {
    return $this->useInlineJs;
  }

  /**
   * @param bool $useInlineJs
   * @return $this
   */
  public function setUseInlineJs(bool $useInlineJs): self
  {
    $this->useInlineJs = $useInlineJs;
    return $this;
  }

  /**
   * @return string
   */
  public function getWrapperClass(): string
  {
    return $this->wrapperClass;
  }

  /**
   * @param string $wrapperClass
   * @return $this
   */
  public function setWrapperClass(string $wrapperClass): self
  {
    $this->wrapperClass = $wrapperClass;
    return $this;
  }

  /**
   * @return $this
   */
  public function withCustomFields(): self
  {
    $customFields = [
      "customSelect" => CustomSelectField::class,
      "recursiveSelect" => RecursiveSelectField::class,
      "customRadio" => CustomRadioField::class,
      "editor" => EditorField::class,
      "onOff" => OnOffField::class,
      "mediaImage" => MediaImageField::class,
      "singleImage" => SingleImageField::class,
      "categoryMulti" => MultiCheckboxRecursiveField::class,
      "html" => HtmlField::class,
      "datetime" => DateTimeField::class,
      "time" => TimeField::class,
      "autocomplete" => AutocompleteField::class,
      /*'customRadio'  => CustomRadioField::class,
            'customColor'  => ColorField::class,


            */
    ];

    foreach ($customFields as $key => $field) {
      if (!$this->formHelper->hasCustomField($key)) {
        $this->addCustomField($key, $field);
      }
    }

    return apply_filters("form_custom_fields", $this, $this->formHelper);
  }

  /**
   * @param string $name
   * @param string $class
   * @return $this|Form
   */
  public function addCustomField($name, $class)
  {
    parent::addCustomField($name, $class);

    return $this;
  }

  /**
   * @return $this
   */
  public function hasTabs(): self
  {
    $this->setFormOption("template", "base::forms.form-tabs");
    return $this;
  }

  /**
   * @return int
   */
  public function hasMainFields()
  {
    if (!$this->breakFieldPoint) {
      return count($this->fields);
    }

    $mainFields = [];

    /**
     * @var FormField $field
     */
    foreach ($this->fields as $field) {
      if ($field->getName() == $this->breakFieldPoint) {
        break;
      }

      $mainFields[] = $field;
    }

    return count($mainFields);
  }

  /**
   * @return $this
   */
  public function disableFields()
  {
    parent::disableFields();
    return $this;
  }

  /**
   * @param array $options
   * @param bool $showStart
   * @param bool $showFields
   * @param bool $showEnd
   * @return string
   */
  public function renderForm(
    array $options = [],
    $showStart = true,
    $showFields = true,
    $showEnd = true
  ): string {
    //Assets::add(['form-validation', 'are-you-sure']);
    Assets::add([
      "https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css",
    ]);
    Assets::addJs([
      "https://code.jquery.com/jquery-migrate-3.0.1.js",
      "https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js",
    ]);

    apply_filters(BASE_FILTER_BEFORE_RENDER_FORM, $this, $this->getModel());

    return parent::renderForm($options, $showStart, $showFields, $showEnd);
  }

  /**
   * @return string
   * @throws Exception
   */
  public function renderValidatorJs(): string
  {
    $element = null;
    if ($this->getFormOption("id")) {
      $element = "#" . $this->getFormOption("id");
    } elseif ($this->getFormOption("class")) {
      $element = "." . $this->getFormOption("class");
    }

    return JsValidator::formRequest($this->getValidatorClass(), $element);
  }

  /**
   * @return string
   */
  public function getValidatorClass(): string
  {
    return $this->validatorClass;
  }

  /**
   * @param string $validatorClass
   * @return $this
   */
  public function setValidatorClass($validatorClass): self
  {
    $this->validatorClass = $validatorClass;
    return $this;
  }

  /**
   * Setup model for form, add namespace if needed for child forms.
   *
   * @return $this
   */
  protected function setupModel($model)
  {
    if (!$this->model) {
      $this->model = $model;
      $this->setupNamedModel();
    }

    return $this;
  }
}
