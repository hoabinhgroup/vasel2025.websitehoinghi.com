<?php

namespace Modules\Api\Forms;

use Modules\Base\Enums\BaseStatusEnum;
use Modules\Base\Forms\FormAbstract;
use Modules\Api\Entities\Api;
use Modules\Api\Http\Requests\ApiRequest;

class ApiForm extends FormAbstract
{
   public function buildForm()
    {

        $this
            ->setupModel(new Api)
            ->setValidatorClass(ApiRequest::class)
            ->withCustomFields()
            ->add('brand_name', 'text', [
                'label'      => 'Brand name',
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => __('base::form.name_placeholder')
                ],
            ])
           
            
            ->add('due', 'number', [
                'label'      => 'Due',
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => __('base::form.name_placeholder')
                ],
            ])     
            ->add('due_info', 'text', [
                'label'      => 'Due Info',
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => __('base::form.name_placeholder')
                ],
            ])
            ->add('brand_id', 'text', [
                'label'      => 'Brand Id',
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
            ->add("brand_logo", "mediaImage", [
                "label" => 'Brand logo',
                "label_attr" => ["class" => "control-label"],
              ])
            ->add('due_date', 'datetime', [
                'label'      => 'Due Date',
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => __('base::form.name_placeholder')
                ],
            ])
            ->setBreakFieldPoint('status');
    }
}
