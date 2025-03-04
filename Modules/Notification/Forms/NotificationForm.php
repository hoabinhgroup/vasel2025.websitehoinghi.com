<?php

namespace Modules\Notification\Forms;

use Modules\Base\Forms\FormAbstract;
use Modules\Notification\Entities\Notification;
use Modules\Notification\Http\Requests\NotificationRequest;

class NotificationForm extends FormAbstract
{
   public function buildForm()
    {

        $this
            ->setupModel(new Notification)
            ->setValidatorClass(NotificationRequest::class)
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
