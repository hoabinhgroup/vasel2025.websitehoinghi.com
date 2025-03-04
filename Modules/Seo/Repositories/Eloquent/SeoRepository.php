<?php

namespace Modules\Seo\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\App;
use Modules\Base\Repositories\Eloquent\EloquentRepository;
use Modules\Seo\Repositories\SeoInterface;
use Illuminate\Support\Carbon;

class SeoRepository extends EloquentRepository implements SeoInterface
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
