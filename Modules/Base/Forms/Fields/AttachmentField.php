<?php

namespace Modules\Base\Forms\Fields;

use Kris\LaravelFormBuilder\Fields\FormField;

class AttachmentField extends FormField
{
  /**
   * {@inheritDoc}
   */
  protected function getTemplate()
  {
    return "base::forms.fields.attachment";
  }
}
