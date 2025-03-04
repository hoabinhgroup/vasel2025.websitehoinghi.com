<?php

namespace Modules\Api\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Base\Traits\ParseContent;
use Modules\Emailmarketing\Entities\Emailtemplate;

class SendEmailSubmit extends Mailable
{
  use Queueable, SerializesModels, ParseContent;

  protected $data;
  /**
   * Create a new message instance.
   *
   * @return void
   */
  public function __construct($data)
  {
    $this->data = $data;
  }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build()
  {
    $pixel = "";
    // $pixel =
    //   '<div style="background:url(' .
    //   route("api.email.open", $this->data["transaction_id"]) .
    //   ')"></div>';

    return $this->from(setting("email_from_address"))
      ->subject('Form Submit')
      ->html(view("api::submit", ['message' => $this->data])->render());
  }
}
