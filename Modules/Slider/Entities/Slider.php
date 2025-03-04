<?php

namespace Modules\Slider\Entities;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

class Slider extends Model
{
  //use SoftDeletes;

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = "sliders";

  /**
   * @var array
   */
  protected $fillable = ["name", "key", "description", "status"];

  public function sliderItems()
  {
    return $this->hasMany(SliderItem::class)->orderBy(
      "slider_items.order",
      "asc"
    );
  }

  protected static function boot()
  {
    parent::boot();

    self::deleting(function (SimpleSlider $slider) {
      SliderItem::where("slider_id", $slider->id)->delete();
    });
  }
}
