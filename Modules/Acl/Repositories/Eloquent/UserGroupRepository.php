<?php

namespace Modules\Acl\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\App;
use Modules\Base\Repositories\Eloquent\EloquentRepository;
use Modules\Acl\Repositories\UserGroupInterface;
use Illuminate\Support\Carbon;

class UserGroupRepository extends EloquentRepository implements UserGroupInterface
{
	protected $screen = USER_GROUP_NAME;
    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \Modules\Acl\Entities\UserGroup::class;
    }


}
