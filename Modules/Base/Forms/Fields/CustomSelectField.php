<?php

namespace Modules\Base\Forms\Fields;

use Kris\LaravelFormBuilder\Fields\SelectType;

class CustomSelectField extends SelectType
{
  /**
   * {@inheritDoc}
   */
  protected function getTemplate()
  {
    return "base::forms.fields.custom-select-options";
  }
}
