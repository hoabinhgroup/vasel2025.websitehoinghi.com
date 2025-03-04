<?php

namespace Modules\Slider\Entities;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

class SliderItem extends Model
{
  //use SoftDeletes;

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = "slider_items";

  /**
   * @var array
   */
  protected $fillable = [
    "title",
    "description",
    "link",
    "image",
    "order",
    "slider_id",
  ];
}
