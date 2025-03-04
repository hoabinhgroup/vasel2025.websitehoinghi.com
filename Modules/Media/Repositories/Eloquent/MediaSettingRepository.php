<?php

namespace Modules\Media\Repositories\Eloquent;

use Modules\Media\Repositories\MediaSettingInterface;
use Modules\Base\Repositories\Eloquent\EloquentRepository;

class MediaSettingRepository extends EloquentRepository implements MediaSettingInterface
{
	/**
	 * get model
	 * @return string
	 */
	public function getModel()
	{
		return \Modules\Media\Entities\MediaSetting::class;
	}
}
