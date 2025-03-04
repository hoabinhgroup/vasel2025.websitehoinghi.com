<?php

namespace Modules\Post\Tables;

use Illuminate\Support\Facades\Auth;
use Modules\Acl\Entities\Users;
use Modules\Post\Entities\Tag;
use Modules\Post\Repositories\TagInterface;
use Modules\Base\Table\TableAbstract;
use Carbon\Carbon;
use Html;
use Illuminate\Contracts\Routing\UrlGenerator;
use DataTables;
use Excel;

class TagTable extends TableAbstract
{
    /**
     * @var bool
     */
    protected $hasActions = false;
    
      /**
     * @var bool
     */
    protected $hasTab = false;
   
    /**
     * @var bool
     */
    protected $hasFilter = false;
      /**
     * @var bool
     */
    protected $hasFilterDateRange = false;

    /**
     * @var int
     */
    protected $defaultSortColumn = 6;

    /**
     * PostTable constructor.
     * @param DataTables $table
     * @param UrlGenerator $urlGenerator
     */
    public function __construct(
        DataTables $table,
        UrlGenerator $urlGenerator,
        TagInterface $tag
    ) {
        $this->repository = $tag;
        $this->setOption('id', 'tag-table');
        parent::__construct($table, $urlGenerator);

        if (Auth::check() && !Auth::user()->can(['tag.edit', 'tag.delete'])) {
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
				->editColumn('author_id', function ($item) {
	       	 		 	return Users::find($item['author_id'])->name;
	       	 	
				})			
				->addColumn('action', function ($item) {
					
                return $this->getActionsButtonRow('tag.edit', 'tag.delete', $item);
              	             	
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
            
            'name'       => [
                'name'  => 'name',
                'title' => __('base::tables.name'),
                'orderable' => false,
                'class' => 'text-left',
            ],
            'author_id'       => [
                'name'  => 'author_id',
                'title' => __('base::tables.author'),
                'orderable' => false,
                'class' => 'text-center',
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
            ],
            'id'         => [
                'name'  => 'id',
                'title' => __('base::tables.id'),
                'width' => '10px'
            ]
        ];
    }
   

    /**
     * {@inheritDoc}
     */
    public function buttons()
    {
      $buttons = $this->addCreateButton(route('tag.create'), 'tag.create');
      
       return apply_filters(BASE_FILTER_TABLE_BUTTONS, $buttons, Post::class);

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
