<?php

namespace Modules\Post\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\App;
use Modules\Base\Repositories\Eloquent\EloquentRepository;
use Modules\Post\Repositories\TagInterface;
use Illuminate\Support\Carbon;

class TagRepository extends EloquentRepository implements TagInterface
{
	
	protected $screen = TAG_SCREEN;
	
    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \Modules\Post\Entities\Tag::class;
    }
     
     
}
