<?php

namespace Modules\Registration\Tables;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
//use Modules\Registration\Exports\ProductExport;
use Modules\Payment\Enums\PaymentMethodEnum;
use Modules\Registration\Entities\SpeakerRegistration;
use Modules\Registration\Enums\PaymentStatusEnums;
use Modules\Acl\Entities\Users;
use Modules\Registration\Entities\Registration;
use Modules\Base\Table\TableAbstract;
use Modules\Payment\Libraries\Onepay;
use Carbon\Carbon;
use Html;
use Illuminate\Contracts\Routing\UrlGenerator;
use DataTables;
use Excel;

class SpeakerRegistrationTable extends TableAbstract
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
        UrlGenerator $urlGenerator
    ) {
        $this->repository = SpeakerRegistration::query();
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

        return $this->table($this->query())

            ->addColumn('action', function ($item) {

                return $this->getActionsButtonRow(null, 'speaker.registration.delete', $item, null, null);
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
                'speaker_registration.id',
                'speaker_registration.fullname',
                'speaker_registration.guest_code',
                'speaker_registration.email',
                'speaker_registration.created_at',

            ], $this->applyCondition());
        // ray()->measure(); 
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
            ]
        ];
    }


    public function buttons()
    {
        $buttons = [
            "export" => [
                "link" => route("speaker.registration.export"),
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
