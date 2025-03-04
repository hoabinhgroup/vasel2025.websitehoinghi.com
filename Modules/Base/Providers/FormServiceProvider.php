<?php

namespace Modules\Base\Providers;

use Form;
use Illuminate\Support\ServiceProvider;

class FormServiceProvider extends ServiceProvider
{
  public function boot()
  {
    Form::component("mediaImage", "base::elements.forms.image", [
      "name",
      "value" => null,
      "attributes" => [],
    ]);
    
    Form::component("singleImage", "base::elements.forms.single-image", [
      "name",
      "value" => null,
      "attributes" => [],
    ]);

    Form::component("modalAction", "base::elements.forms.modal", [
      "name",
      "title",
      "type" => null,
      "content" => null,
      "action_id" => null,
      "action_name" => null,
      "modal_size" => null,
    ]);

    Form::component("helper", "base::elements.forms.helper", ["content"]);

    Form::component("onOff", "base::elements.forms.on-off", [
      "name",
      "value" => false,
      "attributes" => [],
    ]);

    /**
     * Custom checkbox
     * Every checkbox will not have the same name
     */
    Form::component("customCheckbox", "base::elements.custom-checkbox", [
      /**
       * @var array $values
       * @template: [
       *      [string $name, string $value, string $label, bool $selected, bool $disabled],
       *      [string $name, string $value, string $label, bool $selected, bool $disabled],
       *      [string $name, string $value, string $label, bool $selected, bool $disabled],
       * ]
       */
      "values",
    ]);

    /**
     * Custom radio
     * Every radio in list must have the same name
     */
    Form::component("customRadio", "base::forms.partials.custom-radio", [
      /**
       * @var string $name
       */
      "name",
      /**
       * @var array $values
       * @template: [
       *      [string $value, string $label, bool $disabled],
       *      [string $value, string $label, bool $disabled],
       *      [string $value, string $label, bool $disabled],
       * ]
       */
      "values",
      /**
       * @var string|null $selected
       */
      "selected" => null,
    ]);

    Form::component("error", "base::forms.partials.error", [
      "name",
      "errors" => null,
    ]);

    Form::component("editor", "base::elements.forms.editor-input", [
      "name",
      "value" => null,
      "attributes" => [],
    ]);

    Form::component(
      "customSelect",
      "base::elements.forms.custom-select-options",
      [
        "name",
        "list" => [],
        "selected" => null,
        "selectAttributes" => [],
        "optionsAttributes" => [],
        "optgroupsAttributes" => [],
      ]
    );

    Form::component("autocomplete", "base::forms.partials.autocomplete", [
      "name",
      "list" => [],
      "selected" => null,
      "selectAttributes" => [],
      "optionsAttributes" => [],
      "optgroupsAttributes" => [],
    ]);

    Form::component("googleFonts", "base::elements.forms.google-fonts", [
      "name",
      "selected" => null,
      "selectAttributes" => [],
      "optionsAttributes" => [],
    ]);

    Form::component("customColor", "base::elements.forms.color", [
      "name",
      "value" => null,
      "attributes" => [],
    ]);
  }
}
