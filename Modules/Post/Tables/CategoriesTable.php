<?php

namespace Modules\Post\Tables;

use Illuminate\Support\Facades\Auth;
use Modules\Post\Entities\Categories;
use Modules\Post\Repositories\CategoriesInterface;
use Modules\Base\Table\TableAbstract;
use Carbon\Carbon;
use Html;
use Illuminate\Contracts\Routing\UrlGenerator;
use DataTables;
use Excel;
use Modules\Menu\Libraries\Recursive;

class CategoriesTable extends TableAbstract
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
        CategoriesInterface $categories
    ) {
        $this->repository = $categories;
        $this->setOption('id', 'categories-table');

        parent::__construct($table, $urlGenerator);

        if (Auth::check() && !Auth::user()->can(['categories.edit', 'categories.delete'])) {
            $this->hasOperations = false;
            $this->hasActions = false;
        }
        
    }

    /**
     * {@inheritDoc}
     */
    public function ajax()
    {
	
		$categories =  $this->repository;
	    $request = request();

		return $this->table($this->query())					
				->editColumn('name', function ($data) {
	       	 	
	       	 		 return $data['indent_text'] . ' ' . $data['name'];
	   	 		 	
				})
				 ->editColumn('parent', function ($data) use ($categories) {
	       	 		 	$parent = $data['parent'];
	       	 		 	if($parent){
		       	 		return $categories->find($parent)['name'];
			   	 		 }else{
				   	 	return 0;	 
			   	 		 }
				})

				->addColumn('action', function ($data) {
					
                return $this->getActionsButtonRow('categories.edit', 'categories.delete', $data, null, 'categories.restore');
              	             	
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
      $buttons = $this->addCreateButton(route('categories.create'), 'categories.create');
      
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
		    	'options' =>  \Categories::recursive() 
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
