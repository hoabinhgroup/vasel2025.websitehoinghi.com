<?php

namespace Modules\Registration\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Member\Entities\MemberRegistration;
use Modules\Registration\Traits\Attendance;
use Modules\Registration\Entities\Fees;
use Modules\Registration\Entities\GroupFees;
use Modules\Registration\Enums\PaymentStatusEnums;
use Carbon\Carbon;
//use Illuminate\Database\Eloquent\SoftDeletes;

class Registration extends Model
{
    //use SoftDeletes;
    use Attendance;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'registrations';

    /**
     * @var array
     */
    protected $fillable = [
        'guest_code',
        'topic',
        'session',
        'report_lang',
        'report_deadline_summary',
        'report_deadline_full',
        'report_file_summary',
        'report_file_full',
        'journal_vn',
        'title',
        'fullname',
        'work',
        'jobtitle',
        'address',
        'email',
        'phone',
        'is_international',
        'orderinfo',
        'status',
        'txnResponseCode',
        'vpc_TransactionNo'
    ];


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($registration) {
            $registration->is_international = (request()->category == 'LOCAL REGISTRATION') ? 0 : 1;
            $registration->conference_fees = json_encode(request()->feeId);
            $registration->country = request()->country ?? 'VN';
            $registration->title = request()->titleOther ?? request()->title;
            $registration->dietary = request()->dietaryOther ?? request()->dietary;
            $registration->total = request()->totalAmount;
            $registration->guest_code = $registration->generateGuestCode();
        });

        // static::created(function ($registration) {
        //     // $registration->guest_code = $registration->getCode($registration);
        //     // $registration->save();
        // });
    }

    protected function generateGuestCode()
    {
        $prefix = config('registration.email.code');
        $sequence = sprintf("%03s", $this->count() + 1);
        return "{$prefix}-{$sequence}";
    }


    public function getRegisteredAtAttribute()
    {

        return Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('d/m/Y H:i:s');
    }

    public function getConferenceTypeAttribute()
    {

        return $this->category;
    }

    public function getCountryAttribute($value)
    {
        return allCountries()[$value] ?? $value;
    }


    public function getTotalFormattedAttribute()
    {
        if (!$this->total) {
            return $this->total;
        }

        $formatted_total = number_format($this->total, 2);
        return $this->unitByCategory() . $formatted_total;
    }

    public function getTotalTaxFormattedAttribute()
    {
        if (!$this->total) {
            return $this->total;
        }
        ray('$this->unitByCategory()', $this->unitByCategory());
        $formatted_total = number_format($this->total + ($this->total * 0.05), 2);
        return $this->unitByCategory() . $formatted_total;
    }

    public function unitByCategory()
    {
        return ($this->is_international) ? 'US$' : 'VND';
    }

    public function urlAttachmentRegistration($registration)
    {
        return env('APP_NAME') . '/files/registration/' . $registration->id;
    }

    public function urlPassportRegistration($registration)
    {
        return env('APP_NAME') . '/files/registration/passport/' . $registration->id;
    }


    public function getSubjectAttribute()
    {
        return $this->subject = 'APSCVIR 2025 Registration Confirmation ' . $this->title . '. ' . ucfirst($this->fullname);
    }


    public function getRegistrationChannelAttribute()
    {
        if (!$this->payment_method) {
            return $this->registration_channel = 'plenary-invited-speakers';
        } else {
            return $this->registration_channel = $this->payment_method;
        }
    }

    public function paymentStatus($paymentStatus)
    {
        switch ($paymentStatus) {
            case PaymentStatusEnums::SUCCESSFUL:
                $status = PaymentStatusEnums::SUCCESSFUL()->toHtml();
                break;
            case PaymentStatusEnums::CANCELLED:
                $status = PaymentStatusEnums::CANCELLED()->toHtml();
                break;
            case PaymentStatusEnums::FAILED:
                $status = PaymentStatusEnums::FAILED()->toHtml();
                break;
            case PaymentStatusEnums::PENDING:
                $status = PaymentStatusEnums::PENDING()->toHtml();
                break;
            default:
                $status = PaymentStatusEnums::PENDING()->toHtml();
                break;
        }
        return $status;
    }
}
