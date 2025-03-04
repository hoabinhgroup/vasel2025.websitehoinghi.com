<?php

namespace Modules\Media\Tables;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
//use Modules\Media\Exports\ProductExport;
use Modules\Base\Enums\BaseStatusEnum;
use Modules\Acl\Entities\Users;
use Modules\Media\Entities\Media;
use Modules\Media\Repositories\MediaInterface;
use Modules\Base\Table\TableAbstract;
use Carbon\Carbon;
use Html;
use Illuminate\Contracts\Routing\UrlGenerator;
use DataTables;
use Excel;

class MediaTable extends TableAbstract
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
        MediaInterface $media
    ) {
        $this->repository = $media;
        $this->setOption('id', 'media-table');
        parent::__construct($table, $urlGenerator);

        if (Auth::check() && !Auth::user()->can(['media.edit', 'media.delete'])) {
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

                return $this->getActionsButtonRow('media.edit', 'media.delete', $item, null, 'media.restore');

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
      $buttons = $this->addCreateButton(route('media.create'), 'media.create');

       return apply_filters(BASE_FILTER_TABLE_BUTTONS, $buttons, Media::class);

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
          route("media.deletes"),
          "media.deletes",
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
