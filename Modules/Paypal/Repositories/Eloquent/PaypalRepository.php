<?php

namespace Modules\Paypal\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\App;
use Modules\Base\Repositories\Eloquent\EloquentRepository;
use Modules\Paypal\Repositories\PaypalInterface;
use Illuminate\Support\Carbon;

class PaypalRepository extends EloquentRepository implements PaypalInterface
{

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \Modules\Paypal\Entities\Paypal::class;
    }
     
     
}
