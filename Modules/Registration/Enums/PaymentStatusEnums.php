<?php

namespace Modules\Registration\Enums;

use Modules\Base\Enums\BaseStatusEnum;
use Html;
use Modules\Base\Supports\Enum;

/**
 * @method static BaseStatusEnum DRAFT()
 * @method static BaseStatusEnum PUBLISHED()
 */
class PaymentStatusEnums extends Enum
{
  public const SUCCESSFUL = "successful";
  public const CANCELLED = "cancelled";
  public const FAILED = "failed";
  public const PENDING = "pending";

  /**
   * @var string
   */
  public static $langPath = "registration::enums.status";

  /**
   * @return string
   */
  public function toHtml()
  {

	switch ($this->value) {
	  case self::CANCELLED:
			return Html::tag("span", self::CANCELLED()->label(), [
			  "class" => "label label-primary status-label",
			])->toHtml();	
	  case self::PENDING:
		return Html::tag("span", self::PENDING()->label(), [
		  "class" => "label label-warning status-label",
		])->toHtml();
	  case self::SUCCESSFUL:
		return Html::tag("span", self::SUCCESSFUL()->label(), [
		  "class" => "label label-success status-label",
		])->toHtml();
	  case self::FAILED:
			return Html::tag("span", self::FAILED()->label(), [
			  "class" => "label label-danger status-label",
		])->toHtml();
	  default:
		return parent::toHtml();
	}
  }
}
