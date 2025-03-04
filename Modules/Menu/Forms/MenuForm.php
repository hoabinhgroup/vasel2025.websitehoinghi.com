<?php

namespace Modules\Menu\Forms;

use Modules\Base\Forms\FormAbstract;
use Modules\Menu\Entities\Categories;
use Modules\Menu\Http\Requests\CategoriesRequest;

class MenuForm extends FormAbstract
{
   public function buildForm()
    {

	if ($this->getModel()) {

		$parent = $this->model->parent;
		$key = $this->model->key;

		}
        $this
            ->setupModel(new Categories)
            ->setValidatorClass(CategoriesRequest::class)
            ->withCustomFields()
           // ->addCustomField('tags', TagField::class)
            ->add('name', 'text', [
                'label'      => __('base::form.title'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => __('base::form.name_placeholder'),
                    'onkeyup' => 'ChangeToSlug()'
                ],
            ])
            ->add('slug', 'text', [
                'label'      => __('base::form.slug'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => __('base::form.slug_placeholder')
                ],
                'value' => old('slug', $key ?? '')
            ])
            ->add('description', 'editor', [
                'label'      => __('base::form.content'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'rows'         => 4,
                    'placeholder'  => __('base::form.description_placeholder')
                ],
            ])
            ->add('status', 'onOff', [
                'label'         => __('base::form.status'),
                'label_attr'    => ['class' => 'control-label'],
                'default_value' => true,
            ])
           ->add('parent', 'recursiveSelect', [
                'label'      => __('base::form.categories'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'class' => 'chosen-select form-control select-search-full',
                ],
                'choices'    => \Menu::recursive(),
                'value'		 => old('parent', $parent ?? 0)
            ])
            ->add('image', 'mediaImage', [
                'label'      => __('base::form.cover'),
                'label_attr' => ['class' => 'control-label'],
            ])
            ->setBreakFieldPoint('status');
    }
}
