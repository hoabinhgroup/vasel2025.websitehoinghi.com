<?php

namespace Modules\Registration\Forms;

use Modules\Base\Enums\BaseStatusEnum;
use Modules\Base\Forms\FormAbstract;
use Modules\Registration\Entities\Registration;
use Modules\Registration\Http\Requests\RegistrationRequest;

class RegistrationForm extends FormAbstract
{
   public function buildForm()
    {

        $this
            ->setupModel(new Registration)
            ->setValidatorClass(RegistrationRequest::class)
            ->withCustomFields()
            ->add('name', 'text', [
                'label'      => __('base::form.title'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => __('base::form.name_placeholder')
                ],
            ])
            ->add("status", "select", [
                "label" => trans("base::form.status"),
                "label_attr" => ["class" => "control-label required"],
                "choices" => BaseStatusEnum::labels(),
            ])
            ->setBreakFieldPoint('status');
    }
}
