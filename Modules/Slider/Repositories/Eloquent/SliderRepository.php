<?php

namespace Modules\Slider\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\App;
use Modules\Base\Repositories\Eloquent\EloquentRepository;
use Modules\Slider\Repositories\SliderInterface;
use Illuminate\Support\Carbon;

class SliderRepository extends EloquentRepository implements SliderInterface
{

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \Modules\Slider\Entities\Slider::class;
    }
     
     
}
