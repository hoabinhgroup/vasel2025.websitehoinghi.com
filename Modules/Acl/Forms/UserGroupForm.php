<?php

namespace Modules\Acl\Forms;

use Modules\Base\Forms\FormAbstract;
use Modules\Acl\Entities\UserGroup;
use Modules\Acl\Http\Requests\UserGroupRequest;
use Modules\Acl\Repositories\UserGroupInterface;

class UserGroupForm extends FormAbstract
{

    public function buildForm()
    {
	

        $this
            ->setupModel(new UserGroup)
            ->setValidatorClass(UserGroupRequest::class)
            ->withCustomFields()
            ->add('name', 'text', [
                'label'      => __('base::form.title'),
                'label_attr' => ['class' => 'control-label required']
            ]);
    }
}
