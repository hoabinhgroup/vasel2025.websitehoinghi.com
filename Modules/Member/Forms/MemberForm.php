<?php

namespace Modules\Member\Forms;

use Modules\Base\Enums\BaseStatusEnum;
use Modules\Base\Forms\FormAbstract;
use Modules\Member\Entities\Member;
use Modules\Member\Http\Requests\MemberRequest;

class MemberForm extends FormAbstract
{
   public function buildForm()
    {

        $this
            ->setupModel(new Member)
            ->setValidatorClass(MemberRequest::class)
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
