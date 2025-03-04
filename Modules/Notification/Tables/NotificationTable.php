<?php

namespace Modules\Notification\Tables;

use Illuminate\Support\Facades\Auth;
use Modules\Acl\Entities\Users;
use Modules\Notification\Entities\Notification;
use Modules\Notification\Repositories\NotificationInterface;
use Modules\Base\Table\TableAbstract;
use Carbon\Carbon;
use Html;
use Illuminate\Contracts\Routing\UrlGenerator;
use DataTables;
use Excel;

class NotificationTable extends TableAbstract
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
        NotificationInterface $notification
    ) {
        $this->repository = $notification;
        $this->setOption('id', 'notification-table');
        parent::__construct($table, $urlGenerator);

        if (Auth::check() && !Auth::user()->can(['notification.edit', 'notification.delete'])) {
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
				->editColumn('content_notify',function($item){
					$data = json_decode($item['data']);
					return $data->thread->body; 
				})	
				->editColumn('notifiable_id',function($item){
					if(Users::find($item['notifiable_id'])){
	       	 		 	return Users::find($item['notifiable_id'])->name;
	       	 		 	}
	       	 		 
	       	 		 return 'Empty';
				})
				->editColumn('subject',function($item){
					$data = json_decode($item['data']);
					return $data->thread->thread_name; 
				})
				->editColumn('type',function($item){
					return __('notification::notification.'.snake_case(class_basename($item['type']))); 
				})
				
				->addColumn('action', function ($item) {
					
                return $this->getActionsButtonRow('notification.edit', 'notification.delete', $item, null, 'notification.restore');
              	             	
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
	        'content_notify'       => [
                'name'  => 'content_notify',
                'title' => __('notification::tables.content_notify'),
                'orderable' => false,
                'class' => 'text-left',
            ],  
            'notifiable_id'       => [
                'name'  => 'notifiable_id',
                'title' => __('notification::tables.notifiable_id'),
                'orderable' => false,
                'class' => 'text-left',
            ],      
            'type'       => [
                'name'  => 'type',
                'title' => __('notification::tables.type'),
                'orderable' => false,
                'class' => 'text-left',
                'width' => '200px'
            ],     
            'subject'       => [
                'name'  => 'subject',
                'title' => __('notification::tables.subject'),
                'orderable' => false,
                'class' => 'text-left',
            ],
            'read_at'       => [
                'name'  => 'read_at',
                'title' => __('notification::tables.read_at'),
                'orderable' => false,
                'class' => 'text-center',
            ],
            'created_at'       => [
                'name'  => 'created_at',
                'title' => __('base::tables.created_at'),
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
      $buttons = $this->addCreateButton(route('notification.create'), 'notification.create');
      
       return apply_filters(BASE_FILTER_TABLE_BUTTONS, $buttons, Notification::class);

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
