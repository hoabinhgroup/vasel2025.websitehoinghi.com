<?php

namespace Modules\Analytics\Tables;

use Illuminate\Support\Facades\Auth;
use Modules\Acl\Entities\Users;
use Modules\Analytics\Entities\Analytics;
use Modules\Analytics\Repositories\AnalyticsInterface;
use Modules\Base\Table\TableAbstract;
use Carbon\Carbon;
use Html;
use Illuminate\Contracts\Routing\UrlGenerator;
use DataTables;
use Excel;

class AnalyticsTable extends TableAbstract
{
    /**
     * @var bool
     */
    protected $hasActions = true;
    
      /**
     * @var bool
     */
    protected $hasTab = false;
   
      /**
     * @var bool
     */
    protected $hasFilterDateRange = false;

    /**
     * @var int
     */
    protected $defaultSortColumn = 1;

    /**
     * PostTable constructor.
     * @param DataTables $table
     * @param UrlGenerator $urlGenerator
     */
    public function __construct(
        DataTables $table,
        UrlGenerator $urlGenerator,
        AnalyticsInterface $analytics
    ) {
        $this->repository = $analytics;
        $this->setOption('id', 'analytics-table');
        parent::__construct($table, $urlGenerator);

        if (Auth::check() && !Auth::user()->can(['analytics.edit', 'analytics.delete'])) {
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
				->editColumn('user_id', function ($item) {
	       	 		 	return Users::find($item['user_id'])->name;
	       	 	
				})			

				->addColumn('action', function ($item) {
					
                return $this->getActionsButtonRow('analytics.edit', 'analytics.delete', $item, null, 'analytics.restore');
              	             	
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
                'width' => '10px'
            ],
            'name'       => [
                'name'  => 'name',
                'title' => __('base::tables.name'),
                'orderable' => false,
                'class' => 'text-left',
            ],
            'status'       => [
                'name'  => 'status',
                'title' => __('base::tables.status'),
                'orderable' => false,
                'class' => 'text-center',
            ],
            'created_at'       => [
                'name'  => 'created_at',
                'title' => __('base::tables.created_at'),
                'orderable' => false,
                'class' => 'text-center',
            ],
            'updated_at'       => [
                'name'  => 'updated_at',
                'title' => __('base::tables.updated_at'),
                'orderable' => false,
                'class' => 'text-center',
            ]
        ];
    }
   

    /**
     * {@inheritDoc}
     */
    public function buttons()
    {
      
       return apply_filters(BASE_FILTER_TABLE_BUTTONS, [], Analytics::class);

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
