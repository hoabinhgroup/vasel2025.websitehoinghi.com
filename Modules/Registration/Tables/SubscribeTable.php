<?php

namespace Modules\Registration\Tables;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
//use Modules\Registration\Exports\ProductExport;
use Modules\Registration\Enums\SubscribeStatusEnums;
use Modules\Acl\Entities\Users;
use Modules\Registration\Entities\Subscribe;
use Modules\Base\Table\TableAbstract;
use Carbon\Carbon;
use Html;
use Illuminate\Contracts\Routing\UrlGenerator;
use DataTables;
use Excel;

class SubscribeTable extends TableAbstract
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
        Subscribe $registration
    ) {
        $this->repository = $registration;
        $this->setOption('id', 'subscribe-table');
        parent::__construct($table, $urlGenerator);

        $this->hasOperations = false;
        if (Auth::check()) {
            
          //  $this->hasActions = false;
        }

    }

    /**
     * {@inheritDoc}
     */
    public function ajax()
    {


		return $this->table($this->query())
                ->editColumn('status', function($item) {
                    return $item->status;
                })
				->addColumn('action', function ($item) {

                return $this->getActionsButtonRow(null, null, $item, null, null);

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
            'email_subscribe'       => [
                'name'  => 'email_subscribe',
                'title' => __('registration::tables.email'),
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
                'title' => 'Ngày đăng ký',
                'orderable' => false,
                'class' => 'text-center',
            ],
            
        ];
    }


    /**
     * {@inheritDoc}
     */
    public function buttons()
    {
      return [];

    }


    public function getActions(): array
    {
	    return [];
    }


    // public function htmlDrawCallbackFunction(): ?string
    // {
    //     return '$(".editable").editable();';
    // }
    /**
       * {@inheritDoc}
       */
      // public function bulkActions(): array
      // {
      //   return $this->addDeleteAction(
      //     route("subscribe.deletes"),
      //     "subscribe.deletes",
      //     parent::bulkActions()
      //   );
      // }

      /**
       * {@inheritDoc}
       */
      public function getBulkChanges(): array
      {
        return [
          "email" => [
            "title" => 'Email',
            "type" => "text",
            "validate" => "required|max:120",
          ],
          "status" => [
            "title" => trans("base::tables.status"),
            "type" => "select",
            "choices" => SubscribeStatusEnums::labels(),
            "validate" => "required|" . Rule::in(SubscribeStatusEnums::values()),
          ],
          "created_at" => [
            "title" => trans("base::tables.created_at"),
            "type" => "date",
          ],
        ];
      }


      public function saveBulkChanges(array $ids, string $inputKey, $inputValue): bool
      {
       
          if ($inputKey === 'status') {
              foreach ($ids as $id) {
   
             $registration = Subscribe::find($id);
             $registration->status = $inputValue;
             $registration->save();
            
              }
      
              return true;
          }
      
          return parent::saveBulkChanges($ids, $inputKey, $inputValue);
      }

    /**
     * {@inheritDoc}
     */
    public function applyFilterCondition($query)
    {
        return parent::applyFilterCondition($query);
    }


}
