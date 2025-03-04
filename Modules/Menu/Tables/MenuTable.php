<?php

namespace Modules\Menu\Tables;

use Illuminate\Support\Facades\Auth;
use Modules\Menu\Entities\Categories;
use Modules\Menu\Repositories\MenuInterface;
use Modules\Base\Table\TableAbstract;
use Carbon\Carbon;
use Html;
use Illuminate\Contracts\Routing\UrlGenerator;
use DataTables;
use Excel;
use Modules\Menu\Libraries\Recursive;

class MenuTable extends TableAbstract
{
    /**
     * @var bool
     */
    protected $hasActions = true;
    
    
    
    protected $hasTab = true;
    
    
    
    /**
     * @var bool
     */
    protected $hasFilter = true;
    
      /**
     * @var bool
     */
    protected $hasFilterDateRange = false;

    /**
     * @var 
     */
    protected $catalog;


    /**
     * @var int
     */
    protected $defaultSortColumn = 3;

    /**
     * PostTable constructor.
     * @param DataTables $table
     * @param UrlGenerator $urlGenerator
     * @param CatalogInterface $catalog
     */
    public function __construct(
        DataTables $table,
        UrlGenerator $urlGenerator,
        MenuInterface $catalog
    ) {
        $this->repository = $catalog;
        $this->setOption('id', 'menu-table');

        parent::__construct($table, $urlGenerator);

        if (Auth::check() && !Auth::user()->can(['menu.edit', 'menu.delete'])) {
            $this->hasOperations = false;
            $this->hasActions = false;
        }
        
    }

    /**
     * {@inheritDoc}
     */
    public function ajax()
    {
	
		$catalog =  $this->repository;
	    $request = request();

		return $this->table($this->query())					
				->editColumn('name', function ($data) {
	       	 	
	       	 		 return $data['indent_text'] . ' ' . $data['name'];
	   	 		 	
				})

				->addColumn('action', function ($data) {
					
                return $this->getActionsButtonRow('menu.edit', 'menu.delete', $data);
              	             	
				})
       	 		 ->make(true);
	   	    }
    
  

    /**
     * {@inheritDoc}
     */
    public function query()
    {
	
	 return collect($this->repository->getCategories($this->applyCondition())); 
       
    }

    /**
     * {@inheritDoc}
     */
    public function columns()
    {
        return [  	                   
            'name'    => [
                'name'  => 'name',
                'title' => __('base::tables.name'),
                'orderable' => false,
                'class' => 'text-left',
            ],
            'parent'   => [
                'name'  => 'parent',
                'title' => __('base::tables.parent'),
                'orderable' => false,
                'width' => '25px',
            ],
             'created_at'   => [
                'name'  => 'created_at',
                'title' => __('base::tables.created_at'),
                'orderable' => false,
                'width' => '15px',
            ],
             'updated_at'   => [
                'name'  => 'updated_at',
                'title' => __('base::tables.updated_at'),
                'orderable' => false,
                'width' => '15px',
            ],
            'id'         => [
                'name'  => 'id',
                'title' => __('base::tables.id'),
                'orderable' => false,
                'width' => '10px',
            ]
        ];
    }
   

    /**
     * {@inheritDoc}
     */
    public function buttons()
    {
      $buttons = $this->addCreateButton(route('menu.create'), 'menu.create');
      
       return apply_filters(BASE_FILTER_TABLE_BUTTONS, $buttons, Categories::class);

    }
    
    
    public function getActions(): array
    {
	   //return [$this->addExcelButton(route('catalog.export'), 'catalog.export')];
	   return [];
    }
  
   
   
    public function getFilterDropdowns(): array 
    {
	    return [
	    		  [
		    	'name' => 'category', 
		    	'defaultOption' => __('base::form.select-categories'), 
		    	'class' => "w200 select2 select2-size form-control", 
		    	'options' =>  \Menu::recursive() 
				 ]
	    	];
    }


    /**
     * {@inheritDoc}
     */
    public function applyFilterCondition($query)
    {
	
        return parent::applyFilterCondition($query);
    }


}
