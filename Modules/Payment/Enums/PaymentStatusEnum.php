<?php

namespace Modules\Payment\Enums;

use Modules\Base\Supports\Enum;
use Html;
use Illuminate\Support\HtmlString;

/**
 * @method static PaymentStatusEnum PENDING()
 * @method static PaymentStatusEnum COMPLETED()
 * @method static PaymentStatusEnum REFUNDING()
 * @method static PaymentStatusEnum REFUNDED()
 * @method static PaymentStatusEnum FRAUD()
 * @method static PaymentStatusEnum FAILED()
 */
class PaymentStatusEnum extends Enum
{
	public const COMPLETED = 'Successful payment';
	public const CANCELLED = 'Cancel of the payment';
	public const FAILED = 'Unsuccessful payment';

	
	public function toHtml()
	  {
		switch ($this->value) {
		  case self::COMPLETED:
			return Html::tag("span", self::COMPLETED()->label(), [
			  "class" => "label-success status-label",
			])->toHtml();
		  case self::CANCELLED:
			return Html::tag("span", self::CANCELLED()->label(), [
			  "class" => "label-warning status-label",
			])->toHtml();
		  case self::FAILED:
			return Html::tag("span", self::FAILED()->label(), [
			  "class" => "label-danger status-label",
			])->toHtml();
		  default:
			return parent::toHtml();
		}
	  }
}
