<?php

namespace Modules\Registration\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\App;
use Modules\Base\Repositories\Eloquent\EloquentRepository;
use Modules\Registration\Repositories\RegistrationInterface;
use Illuminate\Support\Carbon;

class RegistrationRepository extends EloquentRepository implements RegistrationInterface
{

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \Modules\Registration\Entities\Registration::class;
    }
     
     
}
