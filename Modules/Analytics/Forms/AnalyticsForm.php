<?php

namespace Modules\Analytics\Forms;

use Modules\Base\Forms\FormAbstract;
use Modules\Analytics\Entities\Analytics;
use Modules\Analytics\Http\Requests\AnalyticsRequest;

class AnalyticsForm extends FormAbstract
{
   public function buildForm()
    {

        $this
            ->setupModel(new Analytics)
            ->setValidatorClass(AnalyticsRequest::class)
            ->withCustomFields()
            ->add('name', 'text', [
                'label'      => __('base::form.title'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => __('base::form.name_placeholder')
                ],
            ])
            ->add('status', 'onOff', [
                'label'         => __('base::form.status'),
                'label_attr'    => ['class' => 'control-label'],
                'default_value' => true,
            ])       
            ->setBreakFieldPoint('status');
    }
}
