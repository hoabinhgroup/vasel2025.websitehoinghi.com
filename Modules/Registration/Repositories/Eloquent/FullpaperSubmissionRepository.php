<?php

namespace Modules\Registration\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\App;
use Modules\Base\Repositories\Eloquent\EloquentRepository;
use Illuminate\Support\Carbon;
use Modules\Registration\Repositories\FullpaperSubmissionInterface;

class FullpaperSubmissionRepository extends EloquentRepository implements FullpaperSubmissionInterface
{

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \Modules\Registration\Entities\FullpaperSubmission::class;
    }


}
