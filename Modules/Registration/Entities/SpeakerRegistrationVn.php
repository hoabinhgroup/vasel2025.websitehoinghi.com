<?php

namespace Modules\Registration\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Registration\Traits\Attendance;
use Carbon\Carbon;
use OwenIt\Auditing\Contracts\Auditable;
//use Illuminate\Database\Eloquent\SoftDeletes;

class SpeakerRegistrationVn extends Model implements Auditable
{
    //use SoftDeletes;
    use Attendance, \OwenIt\Auditing\Auditable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'speaker_registration_vn';

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
        'cid',
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
        'form_invitation',
        'form_certificate',
        'course_name'
    ];


    protected static function boot()
    {
        parent::boot();

        $setRegistrationData = function ($registration) {
            $registration->title = request()->titleOther ?? request()->title;
            $registration->session = request()->otherSession ?? request()->session;
            $registration->course = request()->other_course ?? request()->course;
            $registration->course_name = json_encode(request()->course_name);
            $registration->report_deadline_summary = Carbon::createFromFormat('d/m/Y', request()->report_deadline_summary)->format('Y-m-d');
            $registration->report_deadline_full = Carbon::createFromFormat('d/m/Y', request()->report_deadline_full)->format('Y-m-d');
        };

        static::creating(function ($registration) use ($setRegistrationData) {
            $setRegistrationData($registration);
            $registration->guest_code = $registration->generateGuestCode();
        });

        static::updating(function ($registration) use ($setRegistrationData) {
            $setRegistrationData($registration);
        });

        // static::created(function ($registration) {
        //     // $registration->guest_code = $registration->getCode($registration);
        //     // $registration->save();
        // });
    }

    protected function generateGuestCode()
    {
        $prefix = config('registration.speaker-registration-vn');
        $sequence = sprintf("%03s", $this->count() + 1);
        return "{$prefix}-{$sequence}";
    }


    public function getRegisteredAtAttribute()
    {

        return Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('d/m/Y H:i:s');
    }

    public function urlReportFileSummary($registration)
    {
        return env('APP_NAME') . '/speaker-registration-vn/report-file-summary/' . $registration->id;
    }

    public function urlReportFileFull($registration)
    {
        return env('APP_NAME') . '/speaker-registration-vn/report-file-full/' . $registration->id;
    }

    public function getReportDeadlineSummaryAttribute()
    {
        if (!isset($this->attributes['report_deadline_summary'])) {
            return ''; // Tránh lỗi khi giá trị null
        }
        return Carbon::createFromFormat('Y-m-d', $this->attributes['report_deadline_summary'])->format('d/m/Y');
    }

    public function getReportDeadlineFullAttribute()
    {
        if (!isset($this->attributes['report_deadline_full'])) {
            return ''; // Tránh lỗi khi giá trị null
        }
        return Carbon::createFromFormat('Y-m-d', $this->attributes['report_deadline_full'])->format('d/m/Y');
    }

    public function subjectCreated()
    {
        return 'VASEL 2025 - Đăng ký báo cáo thành công - ' . $this->title . '. ' . ucfirst($this->fullname);
    }

    public function subjectUpdated()
    {
        return 'VASEL 2025 - Chỉnh sửa thành công - ' . $this->title . '. ' . ucfirst($this->fullname);
    }

    public function updatedUrl()
    {
        if (!$this->attributes['id']) {
            return ''; // Tránh lỗi khi giá trị null
        }
        return route('speaker.registration.vn') . '/?edit=' . $this->attributes['id'];
    }


    public function registrationChannelCreated()
    {
        return 'speaker-registration-vn-created';
    }

    public function registrationChannelUpdated()
    {
        return 'speaker-registration-vn-updated';
    }

}
