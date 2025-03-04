<?php

namespace Modules\Acl\Tables;

use Illuminate\Support\Facades\Auth;
use Modules\Acl\Entities\UserGroup;
use Modules\Acl\Repositories\UserGroupInterface;
use Modules\Acl\Repositories\UserInterface;
use Modules\Base\Table\TableAbstract;
use Carbon\Carbon;
use Html;
use Illuminate\Contracts\Routing\UrlGenerator;
use DataTables;
use Excel;

class UserGroupTable extends TableAbstract
{
    /**
     * @var bool
     */
    protected $hasActions = true;
    
    /**
     * @var int
     */
    protected $defaultSortColumn = 1;

    /**
     * PostTable constructor.
     * @param DataTables $table
     * @param UrlGenerator $urlGenerator
     * @param UserInterface $user
     */
    public function __construct(
        DataTables $table,
        UrlGenerator $urlGenerator,
        UserGroupInterface $userGroup
    ) {
        $this->repository = $userGroup;
        $this->setOption('id', 'user-group-table');
        parent::__construct($table, $urlGenerator);

        if (Auth::check() && !Auth::user()->can(['user-group.edit', 'user-group.delete'])) {
            $this->hasOperations = false;
            $this->hasActions = false;
        }
        
    }

    /**
     * {@inheritDoc}
     */
    public function ajax()
    {

		return $this->table($this->query())				
				->addColumn('action', function ($data) {
					
                return $this->getActionsButtonRow('user-group.edit', 'user-group.delete', $data, view('acl::table.partials.permissions', compact('data'))->render());
              	             	
				})
       	 		 ->make(true);
	   	    }
    
  

    /**
     * {@inheritDoc}
     */
    public function query()
    {
        $model = $this->repository;
                     
        $query = $model
            ->select(['*'], $this->applyCondition());
                       			
       return $this->applyScopes(apply_filters(BASE_FILTER_TABLE_QUERY, $query, $model))->get();
    
    }

    /**
     * {@inheritDoc}
     */
    public function columns()
    {
        return [           
            'id'         => [
                'name'  => 'id',
                'title' => __('base::tables.id'),
                'width' => '1%'
                
            ],
            'name'       => [
                'name'  => 'name',
                'title' => __('base::tables.name'),
                'orderable' => false,
                'class' => 'text-left',
                'width' => '65%'
                              
            ]          
        ];
    }
   

    /**
     * {@inheritDoc}
     */
    public function buttons()
    {
      $buttons = $this->addCreateButton(route('user-group.create'), 'user-group.create');
      
       return apply_filters(BASE_FILTER_TABLE_BUTTONS, $buttons, UserGroup::class);

    }

    
    public function getActions(): array
    {
	    return [];
    }
  

    /**
     * {@inheritDoc}
     */
    public function applyFilterCondition($query)
    {
        return parent::applyFilterCondition($query);
    }


}
