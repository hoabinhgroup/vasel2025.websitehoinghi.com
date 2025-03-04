<?php

namespace Modules\Base\Forms\Fields;

use Kris\LaravelFormBuilder\Fields\SelectType;

class CustomRadioField extends SelectType
{
  /**
   * {@inheritDoc}
   */
  protected function getTemplate()
  {
    return "base::forms.fields.custom-radio";
  }
}
