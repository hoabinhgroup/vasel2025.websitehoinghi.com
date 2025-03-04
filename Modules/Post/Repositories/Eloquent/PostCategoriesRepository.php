<?php

namespace Modules\Post\Repositories\Eloquent;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\App;
use Modules\Base\Repositories\Eloquent\EloquentRepository;
use Modules\Post\Repositories\PostCategoriesInterface;
use Illuminate\Support\Carbon;
use DB;

class PostCategoriesRepository extends EloquentRepository implements PostCategoriesInterface
{
	
	protected $screen = POST_CATEGORIES_SCREEN;
	
	public function init()
	{
		parent::init();
	}
  
	/**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \Modules\Post\Entities\PostCategories::class;
    }
     
}
