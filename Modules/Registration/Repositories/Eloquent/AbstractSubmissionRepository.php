<?php

namespace Modules\Registration\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\App;
use Modules\Base\Repositories\Eloquent\EloquentRepository;
use Modules\Registration\Repositories\AbstractSubmissionInterface;
use Illuminate\Support\Carbon;

class AbstractSubmissionRepository extends EloquentRepository implements AbstractSubmissionInterface
{

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \Modules\Registration\Entities\AbstractSubmission::class;
    }
     
     
}
