<?php

namespace Modules\Registration\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Registration\Traits\Attendance;
use Carbon\Carbon;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Models\Audit;

//use Illuminate\Database\Eloquent\SoftDeletes;

class InviteeRegistrationVn extends Model implements Auditable
{
    //use SoftDeletes;
    use Attendance, \OwenIt\Auditing\Auditable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'invitee_registration_vn';

    /**
     * @var array
     */
    protected $fillable = [
        'guest_code',
        'jobtitle',
        'title',
        'title_other',
        'fullname',
        'work',
        'address',
        'cid',
        'email',
        'phone',
        'gender',
        'birthday',
        'birthmonth',
        'birthyear',
        'training',
        'galadinner',
        'course',
        'experience',
        'course_name',
        'register_reception',
        'course_name',
        'form_invitation',
        'form_certificate',
        'payment_form',
        'payment_method',
        'is_international',
        'orderinfo',
        'status',
        'txnResponseCode',
        'vpc_TransactionNo',
        'unc_statement'
    ];


    protected static function boot()
    {
        parent::boot();

        $setRegistrationData = function ($registration) {
            $registration->title = json_encode(array_filter(request()->title, function ($item) {
                return $item != 'other';
            }));
            $registration->title_other = request()->titleOther;
            $registration->course = request()->other_course ?? request()->course;
        };

        static::creating(function ($registration) use ($setRegistrationData) {
            $setRegistrationData($registration);
            $registration->guest_code = $registration->generateGuestCode();
        });

        static::updating(function ($registration) use ($setRegistrationData) {
            $setRegistrationData($registration);
        });

        static::deleting(function ($registration) {
            Audit::where('auditable_type', self::class)
                ->where('auditable_id', $registration->id)
                ->delete();
        });

        // static::created(function ($registration) {
        //     // $registration->guest_code = $registration->getCode($registration);
        //     // $registration->save();
        // });
    }

    public function generateTags(): array
    {

        $tags = [];


        if ($this->isDirty('unc_statement')) {
            return ['unc_statement'];
        }


        return $tags;
    }

    public function getReportLangAttribute($value)
    {
        if (!isset($this->attributes['report_lang'])) {
            return ''; // Tránh lỗi khi giá trị null
        }
        return $this->attributes['report_lang'] == 'vi' ? 'Tiếng Việt' : 'Tiếng Anh';
    }

    protected function generateGuestCode()
    {
        $prefix = config('registration.invitee-registration-vn');
        $maxId = self::max('id');
        $sequence = sprintf("%03s", $maxId + 1);
        return "{$prefix}-{$sequence}";
    }


    public function getTitleAttribute($value)
    {
        $titleOther = ($this->attributes['title_other'] ? '.' . $this->attributes['title_other'] : '');
        $title = json_decode($value);

        if ($this->attributes['title_other'] && empty($title)) {
            return rtrim($this->attributes['title_other'], '.');
        }

        if (!is_array($title)) {
            $title = [$value]; // fallback nếu không decode được
        }

        $fullTitle = implode(".", $title) . $titleOther;

        return $fullTitle;
    }

    public function getArrTitleAttribute()
    {
        if (!isset($this->attributes['title'])) {
            return [];
        }
        return json_decode($this->attributes['title']);
    }

    public function getRegisteredAtAttribute()
    {

        return Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('d/m/Y H:i:s');
    }


    public function urlShortCV($registration)
    {
        return env('APP_NAME') . '/invitee-registration-vn/shortCV/' . $registration->id;
    }

    public function urlPassport($registration)
    {
        return env('APP_NAME') . '/invitee-registration-vn/passport/' . $registration->id;
    }


    public function urlUncStatement($registration)
    {
        return env('APP_NAME') . '/invitee-registration-vn/unc/' . $registration->id;
    }



    public function subjectCreated()
    {
        return 'VASEL 2025 - Đăng ký tham dự thành công - ' . $this->title . '. ' . ucfirst($this->fullname) . ' - ' . $this->guest_code;
    }

    public function subjectUpdated()
    {
        return 'VASEL 2025 - Chỉnh sửa thành công - ' . $this->title . '. ' . ucfirst($this->fullname) . ' - ' . $this->guest_code;
    }

    public function updatedUrl()
    {
        if (!$this->attributes['id']) {
            return ''; // Tránh lỗi khi giá trị null
        }
        return route('invitee.registration.vn') . '/?edit=' . $this->attributes['id'];
    }


    public function registrationChannelCreated()
    {
        return 'invitee-registration-vn-created';
    }

    public function registrationChannelUpdated()
    {
        return 'invitee-registration-vn-updated';
    }
}
