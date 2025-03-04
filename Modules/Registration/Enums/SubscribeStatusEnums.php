<?php

namespace Modules\Registration\Enums;

use Modules\Base\Enums\BaseStatusEnum;
use Html;

/**
 * @method static BaseStatusEnum DRAFT()
 * @method static BaseStatusEnum PUBLISHED()
 */
class SubscribeStatusEnums extends BaseStatusEnum
{
  public const PUBLISHED = "actived";
  public const DRAFT = "unactive";
  public const PENDING = "pending";

  /**
   * @var string
   */
  public static $langPath = "registration::enums.statuses";

  /**
   * @return string
   */
  public function toHtml()
  {
	switch ($this->value) {
	  case self::DRAFT:
		return Html::tag("span", self::DRAFT()->label(), [
		  "class" => "label-info status-label",
		])->toHtml();
	  case self::PENDING:
		return Html::tag("span", self::PENDING()->label(), [
		  "class" => "label-warning status-label",
		])->toHtml();
	  case self::PUBLISHED:
		return Html::tag("span", self::PUBLISHED()->label(), [
		  "class" => "label-success status-label",
		])->toHtml();
	  default:
		return parent::toHtml();
	}
  }
}
