<?php

namespace Modules\Slug\Repositories;

//use Modules\Base\Repositories\RepositoryInterface;

interface SlugInterface
{
   
   public function createSlug($slug, $id, $screen);
}
