<?php

namespace Modules\Registration\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\App;
use Modules\Base\Repositories\Eloquent\EloquentRepository;
use Modules\Registration\Repositories\VsaRegistrationInterface;
use Illuminate\Support\Carbon;

class VsaRegistrationRepository extends EloquentRepository implements VsaRegistrationInterface
{

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \Modules\Registration\Entities\RegistrationVsa::class;
    }
     
     
}
