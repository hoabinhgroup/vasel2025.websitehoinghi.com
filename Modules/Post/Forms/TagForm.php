<?php

namespace Modules\Post\Forms;

use Modules\Base\Enums\BaseStatusEnum;
use Modules\Base\Forms\FormAbstract;
use Modules\Post\Entities\Tag;
use Modules\Post\Http\Requests\TagRequest;

class TagForm extends FormAbstract
{
   public function buildForm()
    {

        $this
            ->setupModel(new Tag)
            ->setValidatorClass(TagRequest::class)
            ->withCustomFields()
            ->add('name', 'text', [
                'label'      => __('base::form.title'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => __('base::form.name_placeholder')
                ],
            ])
            ->add('description', 'editor', [
                'label'      => __('base::form.description'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'rows'         => 4,
                    'placeholder'  => __('base::form.description_placeholder')
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
