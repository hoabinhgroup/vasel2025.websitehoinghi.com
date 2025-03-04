<?php

namespace Modules\Api\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\App;
use Modules\Base\Repositories\Eloquent\EloquentRepository;
use Modules\Api\Repositories\ApiInterface;
use Illuminate\Support\Carbon;

class ApiRepository extends EloquentRepository implements ApiInterface
{

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \Modules\Api\Entities\Api::class;
    }
     
     
}
