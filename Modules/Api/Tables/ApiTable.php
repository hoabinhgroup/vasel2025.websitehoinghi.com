<?php

namespace Modules\Api\Tables;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
//use Modules\Api\Exports\ProductExport;
use Modules\Base\Enums\BaseStatusEnum;
use Modules\Acl\Entities\Users;
use Modules\Api\Entities\Api;
use Modules\Api\Repositories\ApiInterface;
use Modules\Base\Table\TableAbstract;
use Carbon\Carbon;
use Html;
use Illuminate\Contracts\Routing\UrlGenerator;
use DataTables;
use Excel;

class ApiTable extends TableAbstract
{
    /**
     * @var bool
     */
    protected $hasActions = true;
    /**
    * @var bool
    */
    protected $hasFilter = false;
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
        ApiInterface $api
    ) {
        $this->repository = $api;
        $this->setOption('id', 'api-table');
        parent::__construct($table, $urlGenerator);

        if (Auth::check() && !Auth::user()->can(['api.edit', 'api.delete'])) {
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
        ->editColumn('brand_logo', function($item){
            return HTML::image($item->brand_logo, $item->brand_name, [
              "width" => 50,
              "height" => 50,
            ]);

        })
				
				->addColumn('action', function ($item) {

                return $this->getActionsButtonRow('api.edit', 'api.delete', $item, null);

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

       return $this->applyScopes(apply_filters(BASE_FILTER_TABLE_QUERY, $query, $model));

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
            'brand_logo'       => [
              'name'  => 'brand_logo',
              'title' => 'Brand Logo',
              'orderable' => false,
              'class' => 'text-center',
          ],
            'brand_name'       => [
                'name'  => 'brand_name',
                'title' => 'Brand Name',
                'orderable' => false,
                'class' => 'text-left',
            ],
            'due'       => [
              'name'  => 'due',
              'title' => 'Due',
              'orderable' => false,
              'class' => 'text-center',
            ],
            'due_info'       => [
              'name'  => 'due_info',
              'title' => 'Due Info',
              'orderable' => false,
              'class' => 'text-center',
            ],
            'brand_id'       => [
              'name'  => 'brand_id',
              'title' => 'Brand Id',
              'orderable' => false,
              'class' => 'text-center',
            ],
            'due_date'       => [
              'name'  => 'due_date',
              'title' => 'Due Date',
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
      $buttons = $this->addCreateButton(route('api.create'), 'api.create');

       return apply_filters(BASE_FILTER_TABLE_BUTTONS, $buttons, Api::class);

    }


    public function getActions(): array
    {
	    return [];
    }

    /**
       * {@inheritDoc}
       */
      public function bulkActions(): array
      {
        return $this->addDeleteAction(
          route("api.deletes"),
          "api.deletes",
          parent::bulkActions()
        );
      }

      /**
       * {@inheritDoc}
       */
      public function getBulkChanges(): array
      {
        return [
          "name" => [
            "title" => trans("base::tables.name"),
            "type" => "text",
            "validate" => "required|max:120",
          ],
          "status" => [
            "title" => trans("base::tables.status"),
            "type" => "select",
            "choices" => BaseStatusEnum::labels(),
            "validate" => "required|" . Rule::in(BaseStatusEnum::values()),
          ],
          "created_at" => [
            "title" => trans("base::tables.created_at"),
            "type" => "date",
          ],
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
