<?php

namespace Theme\Vasel2025\Http\Controllers;


use Modules\Registration\Events\RegistrationSubmitEvent;
use Theme;
use Illuminate\Http\Request;
use Modules\Theme\Http\Controllers\PublicController;
use Modules\Registration\Http\Requests\RegistrationRequest;
use Modules\Base\Http\Responses\BaseHttpResponse;
use Modules\Registration\Entities\Registration;
use Modules\Payment\Events\PaymentEvent;
use Modules\Registration\Entities\Fees;
use Modules\Base\Traits\ParseContent;
use Modules\Payment\Enums\PaymentMethodEnum;
use Modules\Payment\Services\OnepayPaymentService;
use Modules\Registration\Events\NotificationAfterSubmit;
use Modules\Registration\Traits\SendRegistrationEmail;
use Assets;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use JsValidator;
use Modules\Registration\Entities\Faculty;
use Modules\Registration\Events\AttachEvent;
use Modules\Registration\Services\RDExtraction;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpWord\IOFactory as PhpWordIOFactory;

class Vasel2025Controller extends PublicController
{
  use ParseContent, SendRegistrationEmail;
  /**
   * {@inheritDoc}
   */
  public function getIndex(BaseHttpResponse $response)
  {

    \SeoHelper::openGraph()->setTitle('');
    \SeoHelper::meta()->setDescription('');
    \SeoHelper::openGraph()->setUrl("/");
    \SeoHelper::openGraph()->setType("home");
    \SeoHelper::meta()->addMeta("keywords", "Louis CMS");
    \SeoHelper::meta()->addMeta("author", "Tuấn Louis");

    // \SeoHelper::meta()->addMeta("robots", "index, follow");
    return parent::getIndex($response);
  }

  public function getView(BaseHttpResponse $response, $key = null)
  {


    if (empty($key)) {
      return $this->getIndex($response);
    }


    $slug = $this->slug->findBy("key", $key);


    if (!$slug) {
      abort(404);
    }


    $result = apply_filters(BASE_FILTER_PUBLIC_SINGLE_DATA, $slug);


    if (isset($result["slug"]["key"]) && $result["slug"]["key"] !== $key) {
      return $response->setNextUrl(route("public.single", $result["slug"]["key"]));
    }


    // dd($result->toArray());

    if (!empty($result) && is_array($result)) {
      if (isset($result["template"])) {
        $result["data"]["template"] = $result["template"];
      }

      $result["view"] =
        $result["type"] == "template" ? "template" : $result["view"];

      $data = $result["data"];

      switch ($key) {
        case 'faculty':
        case 'program':
        case 'scientific-program':
        case 'oral-pre-program':
        case 'awards':
          $result["view"] = $key;
          break;
        default:
          break;
      }

      return view(
        Theme::current() . "::" . $result["view"],
        $data
      );
    }

    abort(404);
  }



  public function registration()
  {

    Assets::addJs([
      asset('vendor/jsvalidation/js/jsvalidation.js'),
      themes('js/registration.js?v=' . time())
    ]);

    $validator = JsValidator::make(
      [
        'title' => 'required',
        'titleOther' => 'required',
        'category' => 'required',
        'fullname' => 'required',
        'affiliation' => 'required',
        'position' => 'required',
        'phone' => 'required',
        'email' => 'required',
        'country' => 'required',
        'passport' => 'required|mimes:jpg,png,pdf|max:8120',
        'galadinner' => 'required',
        'conference_checklist_item' => 'required|min:1',
        //'category_id'=>'required_if:specialize,1|required_if:specialize,2',
        'dietary' => 'required',
        'dietaryOther' => 'required_if:dietary,other',
        'address' => 'required',
        'specialize' => 'required',
        'payment_method' => 'required',
        'attachment' => 'required_without:attach|mimes:jpg,png,pdf|max:8120'
      ],
      [],
      [],
      '#payment-registration',
    )
      ->view('registration::validation')
      ->render();

    return view(Theme::current() . "::registration-form") . $validator;
  }



  public function paymentRegistrationSubmit(Request $request)
  {


    //dd($request->all());

    $registration = Registration::create($request->all());

    event(new AttachEvent($request, $registration));
    if ($request->has('payment_method') && $request->category != 'FACULTY/INVITED SPEAKERS') {
      event(new RegistrationSubmitEvent($request, $registration));

      if ($redirect = $registration->getAttribute(PaymentMethodEnum::ONEPAY_PAYMENT_REDIRECT)) {
        return redirect()->away($redirect);
      }

      if ($viewData = $registration->getAttribute(PaymentMethodEnum::BANK_TRANSFER_FEEDBACK)) {
        return view(Theme::current() . '::partials.payment-registration-successfully', $viewData);
      }
    } else {
      $registration['registration_channel'] = $registration->registration_channel;
      event(new NotificationAfterSubmit($registration));
      return view(Theme::current() . '::partials.plenary-registration-successfully');
    }
  }


  protected function handleRegistrationResponse(OnepayPaymentService $onepayPaymentService)
  {

    $payloadResponse = $onepayPaymentService->handleResponse($_REQUEST);

    $registration = Registration::where('guest_code', $_REQUEST['vpc_OrderInfo'])->first();

    if ($registration) {

      $registration->update(
        [
          'orderinfo' => $_REQUEST['vpc_OrderInfo'],
          'txnResponseCode' => $_REQUEST['vpc_TxnResponseCode'],
          'vpc_TransactionNo' => $_REQUEST['vpc_TransactionNo'] ?? null,
          'status' => $payloadResponse['status']
        ]
      );

      $registration->registration_channel = PaymentMethodEnum::ONEPAY_PAYMENT;
      $registration->payment_status = $payloadResponse['statusen'];
    }

    // event xu ly thong bao sau khi thanh toán thành công. Báo đến email....
    event(new NotificationAfterSubmit($registration)); // array

    return redirect()->route($payloadResponse[PaymentMethodEnum::ONEPAY_PAYMENT_FEEDBACK]);
  }



}
