<?php
namespace Modules\Acl\Forms;

use Modules\Acl\Http\Requests\UpdatePasswordRequest;
use Modules\Base\Forms\FormAbstract;
use Html;
use Modules\Acl\Entities\Users;

class PasswordForm extends FormAbstract
{

    /**
     * {@inheritDoc}
     */
    public function buildForm()
    {
        $this
            ->setupModel(new Users())
            ->setValidatorClass(UpdatePasswordRequest::class)
            ->setFormOption('template', 'base::forms.form-no-wrap')
            ->setFormOption('id', 'password-form')
            ->add('old_password', 'password', [
                'label'      => trans('acl::user.current_password'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'data-counter' => 60,
                ],
            ])
            ->add('rowOpen1', 'html', [
                'html' => '<div class="row">',
            ])
            ->add('password', 'password', [
                'label'      => trans('acl::user.new_password'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'data-counter' => 60,
                ],
                'wrapper'    => [
                    'class' => $this->formHelper->getConfig('defaults.wrapper_class') . ' col-md-6',
                ],
                'help_block' => [
                    'text' => Html::tag('span', 'Password Strength', ['class' => 'hidden'])->toHtml(),
                    'tag'  => 'div',
                    'attr' => [
                        'class' => 'pwstrength_viewport_progress',
                    ],
                ],
            ])
            ->add('password_confirmation', 'password', [
                'label'      => trans('acl::user.confirm_new_password'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'data-counter' => 60,
                ],
                'wrapper'    => [
                    'class' => $this->formHelper->getConfig('defaults.wrapper_class') . ' col-md-6',
                ],
            ])
            ->add('rowClose', 'html', [
                'html' => '</div>',
            ])
            ->setActionButtons(view('acl::button.profile.actions')->render());
    }
}
