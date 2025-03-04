<?php

namespace Modules\Base\Forms\Fields;

use Kris\LaravelFormBuilder\Fields\FormField;

class MediaImageField extends FormField
{
  /**
   * {@inheritDoc}
   */
  protected function getTemplate()
  {
    return "base::forms.fields.media-image";
  }
}
