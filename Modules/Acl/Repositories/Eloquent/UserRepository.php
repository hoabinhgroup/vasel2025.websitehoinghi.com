<?php

namespace Modules\Acl\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\App;
use Modules\Base\Repositories\Eloquent\EloquentRepository;
use Modules\Acl\Repositories\UserInterface;
use Illuminate\Support\Carbon;

class UserRepository extends EloquentRepository implements UserInterface
{
    protected $screen = USER_NAME;
    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \Modules\Acl\Entities\Users::class;
    }
}
