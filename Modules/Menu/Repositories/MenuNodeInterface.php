<?php

namespace Modules\Menu\Repositories;


interface MenuNodeInterface
{
	 public function updateSort($data, $parent = 0);
}
