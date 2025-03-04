<?php

namespace Modules\Registration\Tables;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
//use Modules\Registration\Exports\ProductExport;
use Modules\Payment\Enums\PaymentMethodEnum;
use Modules\Registration\Enums\PaymentStatusEnums;
use Modules\Acl\Entities\Users;
use Modules\Registration\Entities\Registration;
use Modules\Registration\Repositories\RegistrationInterface;
use Modules\Base\Table\TableAbstract;
use Modules\Payment\Libraries\Onepay;
use Carbon\Carbon;
use Html;
use Illuminate\Contracts\Routing\UrlGenerator;
use DataTables;
use Excel;

class RegistrationTable extends TableAbstract
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
        RegistrationInterface $registration
    ) {
        $this->repository = Registration::query();
        $this->setOption('id', 'registration-table');
        parent::__construct($table, $urlGenerator);

        $this->hasOperations = true;
        // if (Auth::check() && !Auth::user()->can(['registration.delete'])) {

        //     $this->hasActions = false;
        // }
    }

    /**
     * {@inheritDoc}
     */
    public function ajax()
    {
        $onepay = new Onepay('international');

        return $this->table($this->query())
            ->editColumn('payment_method', function ($item) {
                if ($item->payment_method == PaymentMethodEnum::ONEPAY_PAYMENT) {
                    return "Online Payment";
                } else {
                    return 'Wire Transfer';
                }
            })
            ->editColumn('status', function ($item) use ($onepay) {

                if ($item->payment_method == PaymentMethodEnum::ONEPAY_PAYMENT) {
                    $paymentStatus = $item->status == 'pending' ? $onepay->getResponseDescription($item->txnResponseCode) : $item->status;
                } else {
                    $paymentStatus = $item->status;
                }

                return $item->paymentStatus($paymentStatus);
            })

            ->addColumn('action', function ($item) {

                return $this->getActionsButtonRow(null, 'registration.delete', $item, null, null);
            })
            ->make(true);
    }



    /**
     * {@inheritDoc}
     */
    public function query()
    {
        $model = $this->repository;
        // ray()->measure();
        $query = $model
            ->select([
                'registrations.id',
                'registrations.fullname',
                'registrations.guest_code',
                'registrations.email',
                'registrations.created_at',
                'registrations.payment_method',
                'registrations.vpc_TransactionNo',
                'registrations.status'

            ], $this->applyCondition());
        // ray()->measure();    
        ray()->showQueries();
        return $this->applyScopes(apply_filters(BASE_FILTER_TABLE_QUERY, $query, $model));
    }

    /**
     * {@inheritDoc}
     */
    public function columns()
    {
        return [
            'id' => [
                'name' => 'id',
                'title' => __('base::tables.id'),
                'width' => '10px'
            ],
            'fullname' => [
                'name' => 'fullname',
                'title' => __('registration::tables.fullname'),
                'orderable' => false,
                'class' => 'text-left',
            ],
            'guest_code' => [
                'name' => 'guest_code',
                'title' => __('registration::tables.guest_code'),
                'orderable' => false,
                'class' => 'text-center',
            ],
            'email' => [
                'name' => 'email',
                'title' => __('registration::tables.email'),
                'orderable' => false,
                'class' => 'text-left',
            ],
            'created_at' => [
                'name' => 'created_at',
                'title' => 'Ngày đăng ký',
                'orderable' => false,
                'class' => 'text-center',
            ],
            'payment_method' => [
                'name' => 'payment_method',
                'title' => __('registration::tables.payment_method'),
                'orderable' => false,
                'class' => 'text-center',
            ],
            'vpc_TransactionNo' => [
                'name' => 'vpc_TransactionNo',
                'title' => 'Trans.ID',
                'orderable' => false,
                'class' => 'text-center',
            ],

            'status' => [
                'name' => 'status',
                'title' => __('base::tables.status'),
                'orderable' => false,
                'class' => 'text-center',
            ]
        ];
    }


    public function buttons()
    {
        $buttons = [
            "export" => [
                "link" => route("registration.export"),
                "class" => "btn btn-info mr-1",
                "text" =>
                Html::tag("i", "", [
                    "class" => "fa fa-file-excel-o",
                ])->toHtml() .
                    " " .
                    "Xuất Excel",
            ],
        ];
        return apply_filters(BASE_FILTER_TABLE_BUTTONS, $buttons, Registration::class);
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
    public function bulkActions(): array
    {
        return [];
    }

    /**
     * {@inheritDoc}
     */
    public function getBulkChanges(): array
    {
        return [
            "status" => [
                "title" => trans("base::tables.status"),
                "type" => "select",
                "choices" => PaymentStatusEnums::labels(),
                "validate" => "required|" . Rule::in(PaymentStatusEnums::values()),
            ]
        ];
    }


    public function saveBulkChanges(array $ids, string $inputKey, $inputValue): bool
    {

        if ($inputKey === 'review_status') {
            foreach ($ids as $id) {

                $registration = Registration::find($id);
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
