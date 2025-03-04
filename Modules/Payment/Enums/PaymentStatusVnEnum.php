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
class PaymentStatusVnEnum extends Enum
{
	public const COMPLETED = 'Thanh toán thành công';
	public const CANCELLED = 'Thanh toán bị hủy';
	public const FAILED = 'Thanh toán không thành công';

	
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
