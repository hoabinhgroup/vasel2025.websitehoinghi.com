<?php

namespace Modules\Paypal\Forms;

use Modules\Base\Enums\BaseStatusEnum;
use Modules\Base\Forms\FormAbstract;
use Modules\Paypal\Entities\Paypal;
use Modules\Paypal\Http\Requests\PaypalRequest;

class PaypalForm extends FormAbstract
{
   public function buildForm()
    {

        $this
            ->setupModel(new Paypal)
            ->setValidatorClass(PaypalRequest::class)
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
