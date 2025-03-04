<?php

namespace Modules\Post\Supports\Abstracts;

use Modules\Post\Entities\Post;
use Modules\Post\Repositories\TagInterface;
use Illuminate\Http\Request;


abstract class StoreTagServiceAbstract
{
    /**
     * @var TagInterface
     */
    protected $tag;

    /**
     * StoreTagService constructor.
     * @param TagInterface $tagRepository
     */
    public function __construct(TagInterface $tag)
    {
        $this->tag = $tag;
    }

    /**
     * @param Request $request
     * @param Post $post
     * @return mixed
     */
    abstract public function execute(Request $request, Post $post);
}
