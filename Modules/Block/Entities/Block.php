<?php

namespace Modules\Block\Entities;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

class Block extends Model
{
  //use SoftDeletes;

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = "blocks";

  /**
   * @var array
   */
  protected $fillable = [
    "name",
    "alias",
    "description",
    "content",
    "status",
    "user_id",
  ];
}
