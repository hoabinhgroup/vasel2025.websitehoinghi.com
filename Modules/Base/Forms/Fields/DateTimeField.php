<?php

namespace Modules\Base\Forms\Fields;

use Assets;
use Kris\LaravelFormBuilder\Fields\FormField;

class DateTimeField extends FormField
{
  /**
   * {@inheritDoc}
   */
  protected function getTemplate()
  {
    Assets::add([
      domain() . "/vendors/js/pickers/dateTime/bootstrap-datetimepicker.min.js",
      domain() . "/vendors/css/pickers/bootrap-datetimepicker.min.css",
    ]);
    // Assets::addCss([
    //   "https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css",
    // ]);
    return "base::forms.fields.datetime";
  }
}
