<?php

namespace App\Tables;

use Illuminate\Support\Facades\Auth;
use App\Models\Attendances;
use App\Models\PhotoboothCheckIn;
use Modules\Base\Table\TableAbstract;
use Carbon\Carbon;
use Html;
use Illuminate\Contracts\Routing\UrlGenerator;
use DataTables;
use Excel;
use DB;

class AttendanceTable extends TableAbstract
{
  /**
   * @var bool
   */
  protected $hasActions = false;

  protected $hasFilter = false;

  protected $hasCheckbox = false;

  protected $hasOperations = false;
  /**
   * @var bool
   */
  protected $hasTab = false;
  /**
   * @var bool
   */
   
  protected $setRowIdByField = 'customer_code';

  protected $view = "base::table.table-only";
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
	UrlGenerator $urlGenerator
  ) {
	$this->repository = new Attendances;
	$this->setOption("id", "attendance-table");
	parent::__construct($table, $urlGenerator);
  }

  public function getAjaxUrl(): string
  {
	return route("public.attendance.table");
  }

  public function imagePhotoboothConfirmStatus($item, $photobooth)
  {
	  $photoBoothStatus = PhotoboothCheckIn::where('customer_code', $item)
		 ->where('photobooth_id', $photobooth)
		 ->exists();
	  if($photoBoothStatus){
		  return '<img width="16" src="/img/checked.png">';
	  }else{
		  return '<img width="16" src="/img/unchecked.png">';
	  }
  }
  /**
   * {@inheritDoc}
   */
  public function ajax()
  {
	return $this->table($this->query())
	
	  ->addColumn("confirm_photobooth", function ($item) {
		  $photobooth_confirms = '';
		  
		  for($photobooth = 1; $photobooth <= 10; $photobooth++){	
			  $photoBoothStatus = $this->imagePhotoboothConfirmStatus($item->id, $photobooth);
			 $photobooth_confirms.= '<span class="photobooth">'.$photoBoothStatus. ' B'. $photobooth. '</span>';
		  }
		return $photobooth_confirms;
	  })
	  ->editColumn("status", function ($item) {
		  return $item->status === 0 
		  	? '<img width="16" src="/img/unchecked.png">'
		  	:'<img width="16" src="/img/checked.png">';
		})
	  ->addColumn("action", function ($item) {
		return $this->getActionsButtonRow(null, null, $item, null);
	  })
	  ->make(true);
  }

  /**
   * {@inheritDoc}
   */
  public function query()
  {
	$model = $this->repository;

	$query = $model->select(["*"], $this->applyCondition());

	return $this->applyScopes(
	  apply_filters(BASE_FILTER_TABLE_QUERY, $query, $model)
	)->get();
  }

  /**
   * {@inheritDoc}
   */
  public function columns()
  {
	return [
	  "id" => [
		"name" => "id",
		"title" => __("base::tables.id"),
		"width" => "10px",
	  ],
	  "customer_code" => [
		  "name" => "customer_code",
		  "title" => "Mã khách hàng",
		  "orderable" => false,
		  "class" => "text-left",
		  "width" => "120px"
	  ],
	  "fullname" => [
		"name" => "fullname",
		"title" => "Họ và tên",
		"orderable" => false,
		"class" => "text-left",
		"width" => "250px"
	  ],
	  "email" => [
		"name" => "email",
		"title" => "Email",
		"orderable" => false,
		"class" => "text-left",
		"width" => "300px"
	  ],
	  "mobile" => [
		"name" => "mobile",
		"title" => 'Mobile',
		"orderable" => false,
		"class" => "text-left",
		"width" => "120px"
	  ],
	  "status" => [
		  "name" => "status",
		  "title" => 'Trạng thái',
		  "orderable" => false,
		  "class" => "text-center",
		],
	 "confirm_photobooth" => [
  		"name" => "confirm_photobooth",
  		"title" => 'Photobooth Confirm Status',
  		"orderable" => false,
  		"class" => "text-left",
	]
	];
  }
  
  
  /**
	 * @return string
	 */
	public function htmlInitCompleteFunction(): ?string
	{
	  return '
	     Echo.channel("attendance-status")
		 	.listen("UpdateAttendanceStatus", (e) => {
			 console.log("Received test event:", e.message);
			 louisData._load()
			 setTimeout(() => {
			 	changeRowBackgroundColor(e.message)
			 }, 2000);
		 	});
		 
		 $("#reload-table").on("click", function(){
			louisData._load()
		 })
		 
		 function changeRowBackgroundColor(object) {
			 console.log("object", object)
				const row = document.querySelector(`#${object}`);
				console.log("row", row)
				if(row){
				console.log("row 2", row)
				row.classList.add("transition"); 
			
				 setTimeout(() => {
				 	row.classList.remove("transition");
				 }, 10000);
			 }
			}
			
		  ';
	  }
  /**
   * {@inheritDoc}
   */
  public function buttons()
  {
	// $buttons = $this->addCreateButton(route('invest.create'), 'invest.create');

	return apply_filters(BASE_FILTER_TABLE_BUTTONS, [], Invest::class);
  }

  public function getActions(): array
  {
	return [];
  }

  

  public function getDom(): ?string
  {
	return "<'datatable-tools row'<'col-md-9 custom-toolbar'><'col-md-3'f>r>t<'datatable-tools row clearfix'<'col-md-4'i><'col-md-8'p>>";
  }

  /**
   * {@inheritDoc}
   */
  public function applyFilterCondition($query)
  {
	
	return parent::applyFilterCondition($query);
  }
}
