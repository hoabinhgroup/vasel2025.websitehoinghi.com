<?php

namespace Modules\Media\Forms;

use Modules\Base\Enums\BaseStatusEnum;
use Modules\Base\Forms\FormAbstract;
use Modules\Media\Entities\Media;
use Modules\Media\Http\Requests\MediaRequest;

class MediaForm extends FormAbstract
{
   public function buildForm()
    {

        $this
            ->setupModel(new Media)
            ->setValidatorClass(MediaRequest::class)
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
