<?php

namespace Modules\Member\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\App;
use Modules\Base\Repositories\Eloquent\EloquentRepository;
use Modules\Member\Repositories\MemberInterface;
use Illuminate\Support\Carbon;

class MemberRepository extends EloquentRepository implements MemberInterface
{

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \Modules\Member\Entities\Member::class;
    }
     
     
}
