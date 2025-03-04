<?php

namespace Modules\Template\Repositories\Eloquent;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\App;
use Modules\Base\Repositories\Eloquent\EloquentRepository;
use Modules\Template\Repositories\TemplateInterface;
use Illuminate\Support\Carbon;

class TemplateRepository extends EloquentRepository implements TemplateInterface
{
	
	protected $screen = TEMPLATE_NAME;
	
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
        return \Modules\Template\Entities\Templates::class;
    }
  
        
}
