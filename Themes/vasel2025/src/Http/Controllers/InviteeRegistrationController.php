<?php

namespace Theme\Vasel2025\Http\Controllers;


use Modules\Registration\Entities\InviteeRegistration;
use Modules\Registration\Entities\SpeakerRegistration;
use Modules\Registration\Events\NotificationAfterSubmit;
use Theme;
use Illuminate\Http\Request;
use Modules\Theme\Http\Controllers\PublicController;
use Modules\Base\Traits\ParseContent;
use Modules\Registration\Traits\SendRegistrationEmail;
use Assets;
use JsValidator;
use Modules\Registration\Events\AttachEvent;

class InviteeRegistrationController extends PublicController
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
        'shortCV' => 'required|mimes:jpg,png,pdf,doc,docx|max:8120',
        'passport' => 'required|mimes:jpg,png,pdf,doc,docx|max:8120',
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
        'payment_form' => 'required',
        'payment_method' => 'required',
      ],
      [
        'title[].required' => 'Please select a title.',
        'titleOther.required_if' => 'Please enter another title.',
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

    return view(Theme::current() . "::invitee-registration-form") . $validator;
  }



  public function submit(Request $request)
  {


    //dd($request->all());
    // if($request->has('id'))
    $registration = InviteeRegistration::updateOrCreate(['id' => $request->id ?? null], $request->all());

    event(new AttachEvent($request, $registration));

    if ($request->id) {
      $registration->subject = $registration->subjectUpdated();
      $registration->registration_channel = $registration->registrationChannelUpdated();
      $view = 'invitee-registration-update-successfully';
    } else {
      $registration->subject = $registration->subjectCreated();
      $registration->registration_channel = $registration->registrationChannelCreated();
      $view = 'invitee-registration-successfully';
    }

    $registration->updatedUrl = $registration->updatedUrl();

    event(new NotificationAfterSubmit($registration));


    return view(Theme::current() . '::partials.' . $view, [
      'id' => $registration->id
    ]);
  }
}
