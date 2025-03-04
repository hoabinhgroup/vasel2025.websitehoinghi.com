<?php

namespace Modules\Slug\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\App;
use Modules\Base\Repositories\Eloquent\EloquentRepository;
use Modules\Slug\Repositories\SlugInterface;
use Illuminate\Support\Carbon;

class SlugRepository extends EloquentRepository implements SlugInterface
{

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \Modules\Slug\Entities\Slug::class;
    }

    public function createSlug($slug, $id, $screen)
    {
       return $this->create([
					  'reference_type' => $screen,
		   			  'reference_id' => $id,
		   			  'key' => $slug
		   			]);
    }

}
