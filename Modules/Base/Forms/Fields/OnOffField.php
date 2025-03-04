<?php

namespace Modules\Base\Forms\Fields;

use Kris\LaravelFormBuilder\Fields\FormField;

class OnOffField extends FormField
{

    /**
     * {@inheritDoc}
     */
    protected function getTemplate()
    {
        return 'base::forms.fields.on-off';
    }
}
