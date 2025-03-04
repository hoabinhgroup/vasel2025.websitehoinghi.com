<?php

namespace Modules\Registration\Repositories\Eloquent;

use Modules\Base\Repositories\Eloquent\EloquentRepository;
use Modules\Registration\Repositories\FacultyInterface;
use Illuminate\Support\Carbon;

class FacultyRepository extends EloquentRepository implements FacultyInterface
{

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \Modules\Registration\Entities\Faculty::class;
    }
}
