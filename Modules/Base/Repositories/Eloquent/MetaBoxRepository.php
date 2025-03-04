<?php

namespace Modules\Base\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\App;
use Modules\Base\Repositories\Eloquent\EloquentRepository;
use Modules\Base\Repositories\MetaBoxInterface;
use Illuminate\Support\Carbon;

class MetaBoxRepository extends EloquentRepository implements MetaBoxInterface
{
	
    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \Modules\Base\Entities\MetaBox::class;
    }
     
     
}
