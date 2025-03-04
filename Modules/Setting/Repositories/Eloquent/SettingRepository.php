<?php

namespace Modules\Setting\Repositories\Eloquent;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\App;
use Modules\Base\Repositories\Eloquent\EloquentRepository;
use Modules\Setting\Repositories\SettingInterface;
use Illuminate\Support\Carbon;
use DB;

class SettingRepository extends EloquentRepository implements SettingInterface
{
	
    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \Modules\Setting\Entities\Setting::class;
    }
  
     
}
