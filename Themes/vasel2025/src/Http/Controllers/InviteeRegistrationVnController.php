<?php

namespace Theme\Vasel2025\Http\Controllers;


use Modules\Registration\Entities\InviteeRegistrationVn;
use Modules\Registration\Events\NotificationAfterSubmit;
use Theme;
use Illuminate\Http\Request;
use Modules\Theme\Http\Controllers\PublicController;
use Modules\Base\Traits\ParseContent;
use Modules\Registration\Traits\SendRegistrationEmail;
use Assets;
use JsValidator;
use Modules\Registration\Events\AttachEvent;

class InviteeRegistrationVnController extends PublicController
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
        'fullname' => 'required',
        'work' => 'required',
        'jobtitle' => 'required',
        'cid' => 'required',
        'address' => 'required',
        'phone' => 'required',
        'email' => 'required',
        'gender' => 'required',
        'birthday' => 'required',
        'birthmonth' => 'required',
        'birthyear' => 'required',
        'training' => 'required',
        'course' => 'required',
        'form_invitation' => 'required',
        'form_certificate' => 'required',
        'other_course' => 'required_if:course,other_course',
        'experience' => 'required',
        'course_name' => 'required|min:1',
        'galadinner' => 'required',
        'payment_form' => 'required',
        'payment_method' => 'required',
      ],
      [
        'title[].required' => 'Vui lòng chọn danh xưng.',
        'titleOther.required_if' => 'Vui lòng nhập danh xưng khác.',
        'fullname.required' => 'Vui lòng nhập họ và tên.',
        'work.required' => 'Vui lòng nhập nơi làm việc.',
        'jobtitle.required' => 'Vui lòng nhập chức danh.',
        'address.required' => 'Vui lòng nhập địa chỉ.',
        'phone.required' => 'Vui lòng nhập số điện thoại.',
        'email.required' => 'Vui lòng nhập email.',
        'gender.required' => 'Vui lòng chọn giới tính.',
        'birthday.required' => 'Vui lòng chọn ngày sinh.',
        'birthmonth.required' => 'Vui lòng chọn tháng sinh.',
        'birthyear.required' => 'Vui lòng chọn năm sinh.',
        'training.required' => 'Vui lòng nhập trình độ học vấn.',
        'course.required' => 'Vui lòng chọn khóa đào tạo.',
        'other_course.required_if' => 'Vui lòng nhập tên khóa đào tạo khác.',
        'experience.required' => 'Vui lòng nhập số năm kinh nghiệm.',
        'course_name.required' => 'Vui lòng nhập tên khóa học.',
        'course_name.min' => 'Tên khóa học phải có ít nhất 1 ký tự.',
        'galadinner.required' => 'Vui lòng xác nhận tham dự tiệc gala.',
      ],
      [],
      '#payment-registration',
    )
      ->view('registration::validation')
      ->render();

    return view(Theme::current() . "::invitee-registration-vn-form") . $validator;
  }



  public function submit(Request $request)
  {


    //dd($request->all());
    // if($request->has('id'))
    $registration = InviteeRegistrationVn::updateOrCreate(['id' => $request->id ?? null], $request->all());

    event(new AttachEvent($request, $registration));

    if ($request->id) {
      $registration->subject = $registration->subjectUpdated();
      $registration->registration_channel = $registration->registrationChannelUpdated();
      $view = 'invitee-registration-vn-update-successfully';
    } else {
      $registration->subject = $registration->subjectCreated();
      $registration->registration_channel = $registration->registrationChannelCreated();
      $view = 'invitee-registration-vn-successfully';
    }

    $registration->updatedUrl = $registration->updatedUrl();

    event(new NotificationAfterSubmit($registration));


    return view(Theme::current() . '::partials.' . $view, [
      'id' => $registration->id
    ]);


  }




}
