<?php

namespace Modules\Base\Forms\Fields;

use Kris\LaravelFormBuilder\Fields\FormField;

class SingleImageField extends FormField
{
  /**
   * {@inheritDoc}
   */
  protected function getTemplate()
  {
    return "base::forms.fields.single-image";
  }
}
