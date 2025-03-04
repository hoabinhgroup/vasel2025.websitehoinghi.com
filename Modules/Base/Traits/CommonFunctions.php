<?php

namespace Modules\Base\Traits;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Modules\Base\Repositories\RepositoryInterface;
use Modules\Menu\Libraries\Recursive;
/**
 * @mixin ServiceProvider
 */
trait CommonFunctions
{
    /**
     * @var string
     */
    protected $repository;
    

    /**
     * @var string
     */
    protected $basePath = null;
    
    public function __construct(RepositoryInterface $repository)
    {
	    $this->repository = $repository;

	  
    }

    public function select($name)
   {
	  return $this->repository->selectbox($name);
   }
   
    public function recursive($root = 0)
    {
	  return $this->repository->getRecursive($root);
	    
    }
    
}
