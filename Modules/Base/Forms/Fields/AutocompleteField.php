<?php

namespace Modules\Base\Forms\Fields;

use Kris\LaravelFormBuilder\Fields\SelectType;

class AutocompleteField extends SelectType
{
  /**
   * {@inheritDoc}
   */
  protected function getTemplate()
  {
    return "base::forms.fields.autocomplete";
  }
}
