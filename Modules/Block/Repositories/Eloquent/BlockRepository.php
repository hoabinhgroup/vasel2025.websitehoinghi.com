<?php

namespace Modules\Block\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\App;
use Modules\Base\Repositories\Eloquent\EloquentRepository;
use Modules\Block\Repositories\BlockInterface;
use Illuminate\Support\Carbon;

class BlockRepository extends EloquentRepository implements BlockInterface
{

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \Modules\Block\Entities\Block::class;
    }
     
     
}
