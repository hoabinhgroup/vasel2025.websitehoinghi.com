<?php

namespace Modules\Base\Forms\Fields;

use Illuminate\Support\Arr;
use Kris\LaravelFormBuilder\Fields\FormField;

class EditorField extends FormField
{

    /**
     * {@inheritDoc}
     */
    protected function getTemplate()
    {
        return 'base::forms.fields.editor';
    }

    /**
     *{@inheritDoc}
     */
    public function render(array $options = [], $showLabel = true, $showField = true, $showError = true)
    {
        $options['class'] = Arr::get($options, 'class', '') . 'form-control';

        $options['id'] = Arr::has($options, 'id') ? $options['id'] : $this->getName();
    

        return parent::render($options, $showLabel, $showField, $showError);
    }
}
