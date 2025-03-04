<?php

namespace Modules\Slider\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\App;
use Modules\Base\Repositories\Eloquent\EloquentRepository;
use Modules\Slider\Repositories\SliderItemInterface;
use Illuminate\Support\Carbon;

class SliderItemRepository extends EloquentRepository implements
  SliderItemInterface
{
  /**
   * get model
   * @return string
   */
  public function getModel()
  {
    return \Modules\Slider\Entities\SliderItem::class;
  }
}
