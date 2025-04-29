<?php

namespace Theme\Vasel2025\Http\Controllers;


use Modules\Registration\Entities\SpeakerRegistration;
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

class SpeakerRegistrationController extends PublicController
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

    $rules = [
      'title[]' => 'required',
      'titleOther' => 'required_if:title[],other',
      'topic' => 'required',
      'session' => 'required',
      'sessionOther' => 'required_if:session,other_session',
      'report_lang' => 'required',
      'report_deadline_summary' => 'required',
      'report_deadline_full' => 'required',
      // 'shortCV' => 'required|mimes:jpg,png,pdf,doc,docx|max:8120',
      // 'passport' => 'required|mimes:jpg,png,pdf,doc,docx|max:8120',
      'journal_vn' => 'required',
      'fullname' => 'required',
      'work' => 'required',
      'organization' => 'required',
      'address' => 'required',
      'phone' => 'required',
      'email' => 'required',
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
    ];

    if (isset($_GET['edit'])) {
      $rules['shortCV'] = 'nullable|mimes:jpg,png,pdf,doc,docx|max:8120';
      $rules['passport'] = 'nullable|mimes:jpg,png,pdf,doc,docx|max:8120';
    } else {
      $rules['shortCV'] = 'required|mimes:jpg,png,pdf,doc,docx|max:8120';
      $rules['passport'] = 'required|mimes:jpg,png,pdf,doc,docx|max:8120';
    }

    $validator = JsValidator::make(
      $rules,
      [
        'title[].required' => 'Please select a title.',
        'titleOther.required_if' => 'Please enter another title.',
        'topic.required' => 'Please select a topic.',
        'session.required' => 'Please select a session.',
        'sessionOther.required_if' => 'Please enter another session.',
        'report_lang.required' => 'Please select the report language.',
        'report_deadline_summary.required' => 'Please enter the summary submission deadline.',
        'report_deadline_full.required' => 'Please enter the full paper submission deadline.',
        'journal_vn.required' => 'Please enter journal information.',
        'fullname.required' => 'Please enter your full name.',
        'work.required' => 'Please enter your workplace.',
        'jobtitle.required' => 'Please enter your job title.',
        'address.required' => 'Please enter your address.',
        'phone.required' => 'Please enter your phone number.',
        'email.required' => 'Please enter your email.',
        'organization.required' => 'Please enter your organization.',
        'gender.required' => 'Please select your gender.',
        'birthday.required' => 'Please select your birth date.',
        'birthmonth.required' => 'Please select your birth month.',
        'birthyear.required' => 'Please select your birth year.',
        'training.required' => 'Please enter your educational background.',
        'course.required' => 'Please select a training course.',
        'other_course.required_if' => 'Please enter another training course name.',
        'experience.required' => 'Please enter your years of experience.',
        'course_name.required' => 'Please enter the course name.',
        'course_name.min' => 'The course name must have at least 1 character.',
        'galadinner.required' => 'Please confirm your attendance at the gala dinner.',
        'shortCV.required' => 'Please upload your short CV.',
        'passport.required' => 'Please upload your short Passport.',
      ],
      [],
      '#payment-registration',
    )
      ->view('registration::validation')
      ->render();

    return view(Theme::current() . "::speaker-registration-form") . $validator;
  }



  public function submit(Request $request)
  {


    //  dd($request->all());
    // if($request->has('id'))
    $registration = SpeakerRegistration::updateOrCreate(['id' => $request->id ?? null], $request->except(['report_file_summary', 'report_file_full', 'shortCV', 'passport']));

    event(new AttachEvent($request, $registration));

    if ($request->id) {
      $registration->subject = $registration->subjectUpdated();
      $registration->registration_channel = $registration->registrationChannelUpdated();
      $view = 'speaker-registration-update-successfully';
    } else {
      $registration->subject = $registration->subjectCreated();
      $registration->registration_channel = $registration->registrationChannelCreated();
      $view = 'speaker-registration-successfully';
    }

    $registration->updatedUrl = $registration->updatedUrl();

    event(new NotificationAfterSubmit($registration));


    return view(Theme::current() . '::partials.' . $view, [
      'id' => $registration->id
    ]);
  }
}
