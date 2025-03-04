<?php

namespace Modules\Menu\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\App;
use Modules\Base\Repositories\Eloquent\EloquentRepository;
use Modules\Menu\Repositories\MenuNodeInterface;
use Illuminate\Support\Carbon;

class MenuNodeRepository extends EloquentRepository implements MenuNodeInterface
{
	protected $screen = MENU_NODE_NAME;
	
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
        return \Modules\Menu\Entities\MenuNode::class;
    }
    
    public function updateSort($data, $parent = 0)
    {
	    $loop = 0;
	    foreach($data as $val): $loop++;

	$this->_model->updateOrCreate(['id' => $val['id']], 
					['position' => $loop, 
					'parent_id' => $parent,
					'has_child' => isset($val['children'])?1:0
					 ]);
	
	if(isset($val['children']))
	{		
		$this->updateSort($val['children'], $val['id']);
	}
	
		endforeach;
		
		
    }
	
}
