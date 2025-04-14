<?php

namespace Theme\Vasel2025\Http\Controllers;


use Modules\Registration\Entities\SpeakerRegistrationVn;
use Modules\Registration\Events\NotificationAfterSubmit;
use Theme;
use Illuminate\Http\Request;
use Modules\Theme\Http\Controllers\PublicController;
use Modules\Base\Traits\ParseContent;
use Modules\Registration\Traits\SendRegistrationEmail;
use Assets;
use JsValidator;
use Modules\Registration\Events\AttachEvent;

class SpeakerRegistrationVnController extends PublicController
{
  use ParseContent, SendRegistrationEmail;
  /**
   * {@inheritDoc}
   */


  public function form()
  {

    // Assets::addJs([
    //   asset('vendor/jsvalidation/js/jsvalidation.js'),
    //   themes('js/speaker-registration.js?v=' . time())
    // ]);

    $validator = JsValidator::make(
      [
        'title[]' => 'required',
        'titleOther' => 'required_if:title[],other',
        'topic' => 'required',
        'session' => 'required',
        'sessionOther' => 'required_if:session,other_session',
        'report_lang' => 'required',
        'report_deadline_summary' => 'required',
        'report_deadline_full' => 'required',
        'journal_vn' => 'required',
        'fullname' => 'required',
        'work' => 'required',
        'jobtitle' => 'required',
        'address' => 'required',
        'phone' => 'required',
        'email' => 'required',
        'cid' => 'required',
        'gender' => 'required',
        'birthday' => 'required|numeric',
        'birthmonth' => 'required|numeric',
        'birthyear' => 'required|numeric',
        'training' => 'required',
        'course' => 'required',
        'other_course' => 'required_if:course,other_course',
        'experience' => 'required',
        'course_name' => 'required|min:1',
        'galadinner' => 'required',
        'form_invitation' => 'required',
        'form_certificate' => 'required',
      ],
      [
        'title[].required' => 'Vui lòng chọn ít nhất 1 danh xưng.',
        'titleOther.required_if' => 'Vui lòng nhập danh xưng khác.',
        'topic.required' => 'Vui lòng chọn chủ đề.',
        'session.required' => 'Vui lòng chọn phiên làm việc.',
        'sessionOther.required_if' => 'Vui lòng nhập phiên làm việc khác.',
        'report_lang.required' => 'Vui lòng chọn ngôn ngữ báo cáo.',
        'report_deadline_summary.required' => 'Vui lòng nhập hạn chót nộp tóm tắt.',
        'report_deadline_full.required' => 'Vui lòng nhập hạn chót nộp toàn văn.',
        'journal_vn.required' => 'Vui lòng nhập thông tin tạp chí.',
        'fullname.required' => 'Vui lòng nhập họ và tên.',
        'work.required' => 'Vui lòng nhập nơi công tác.',
        'jobtitle.required' => 'Vui lòng nhập chức danh.',
        'address.required' => 'Vui lòng nhập địa chỉ.',
        'phone.required' => 'Vui lòng nhập số điện thoại.',
        'email.required' => 'Vui lòng nhập email.',
        'cid.required' => 'Vui lòng nhập số CMND/CCCD.',
        'gender.required' => 'Vui lòng chọn giới tính.',
        'birthday.required' => 'Vui lòng chọn ngày sinh.',
        'birthmonth.required' => 'Vui lòng chọn tháng sinh.',
        'birthyear.required' => 'Vui lòng chọn năm sinh.',
        'training.required' => 'Vui lòng nhập trình độ đào tạo.',
        'course.required' => 'Vui lòng chọn khóa đào tạo.',
        'other_course.required_if' => 'Vui lòng nhập tên khóa đào tạo khác.',
        'experience.required' => 'Vui lòng nhập số năm kinh nghiệm.',
        'course_name.required' => 'Vui lòng nhập tên khóa học.',
        'course_name.min' => 'Tên khóa học phải có ít nhất 1 ký tự.',
        'galadinner.required' => 'Vui lòng xác nhận tham dự gala dinner.',
        'form_invitation.required' => 'Vui lòng xác nhận nhận thư mời.',
        'form_certificate.required' => 'Vui lòng xác nhận nhận chứng nhận tham dự.',
      ],
      [],
      '#payment-registration',
    )
      ->view('registration::validation')
      ->render();

    return view(Theme::current() . "::speaker-registration-vn-form") . $validator;
  }



  public function submit(Request $request)
  {


    //  dd($request->all());
    // if($request->has('id'))
    $registration = SpeakerRegistrationVn::updateOrCreate(['id' => $request->id ?? null], $request->except(['report_file_summary', 'report_file_full']));

    event(new AttachEvent($request, $registration));

    if ($request->id) {
      $registration->subject = $registration->subjectUpdated();
      $registration->registration_channel = $registration->registrationChannelUpdated();
      $view = 'speaker-registration-vn-update-successfully';
    } else {
      $registration->subject = $registration->subjectCreated();
      $registration->registration_channel = $registration->registrationChannelCreated();
      $view = 'speaker-registration-vn-successfully';
    }

    $registration->updatedUrl = $registration->updatedUrl();

    event(new NotificationAfterSubmit($registration));


    return view(Theme::current() . '::partials.' . $view, [
      'id' => $registration->id
    ]);
  }
}
