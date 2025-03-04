<?php

namespace Modules\Menu\Forms;

use Modules\Base\Forms\FormAbstract;
use Modules\Menu\Entities\Menu;
use Modules\Menu\Http\Requests\MenuRequest;
use Assets;

class MenusForm extends FormAbstract
{
   public function buildForm()
    {

	    Assets::add([
         config('app.url') . '/css/drag-menu.css',
      	 config('app.url') . '/assets/css/jquery-ui.custom.css',
      	 config('app.url') . '/assets/css/chosen.css',
      	// config('app.url') . '/uploadifive/jquery.uploadifive.min.js',
      	 config('app.url') . '/assets/js/bootstrap-multiselect.js',
      	 config('app.url') . '/assets/js/chosen.jquery.js',
      	 config('app.url') . '/js/handlebars-v4.0.11.js',
      	 config('app.url') . '/js/plugins/jquery.nestable.min.js',
      	 config('app.url') . '/js/menunode.js'
      	]);


	if ($this->getModel()) {

		$parent = $this->model->parent;
		$key = $this->model->key;

		}
        $this
            ->setupModel(new Menu)
            ->setValidatorClass(MenuRequest::class)
            ->setFormOption('class', 'form-save-menu')
            ->withCustomFields()
           // ->addCustomField('tags', TagField::class)
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
            ->addMetaBoxes([
                'structure' => [
                    'wrap'    => false,
                    'content' => view('menu::cmspanel.menu-structure', [
                        'menu'      => $this->getModel()
                    ])->render(),
                ],
            ])
            ->setBreakFieldPoint('status');
    }
}
