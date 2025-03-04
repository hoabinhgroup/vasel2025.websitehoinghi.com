<?php

namespace Modules\Notification\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\App;
use Modules\Base\Repositories\Eloquent\EloquentRepository;
use Modules\Notification\Repositories\NotificationInterface;
use Illuminate\Support\Carbon;

class NotificationRepository extends EloquentRepository implements NotificationInterface
{

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \Modules\Notification\Entities\Notification::class;
    }
     
     
}
