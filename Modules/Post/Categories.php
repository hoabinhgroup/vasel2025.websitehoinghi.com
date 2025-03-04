<?php

namespace Modules\Post;

use Modules\Post\Repositories\CategoriesInterface;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Input;
use Modules\Base\Traits\CommonFunctions;
use Schema;
use Theme;

class Categories
{
	use CommonFunctions;
    /**
     * @var mixed
     */
    protected $categories; 



    public function __construct(
        CategoriesInterface $categories
    )
    {
	    $this->categories = $categories;
	    $this->repository = $categories;

    }

}
