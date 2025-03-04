<?php

namespace Modules\Post\Supports\Abstracts;

use Modules\Post\Entities\Post;
use Modules\Post\Repositories\CategoriesInterface;
use Illuminate\Http\Request;

abstract class StoreCategoryServiceAbstract
{
    /**
     * @var CategoryInterface
     */
    protected $categories;

    /**
     * StoreCategoryServiceAbstract constructor.
     * @param CatalogInterface $categoryRepository
     */
    public function __construct(CategoriesInterface $categories)
    {
        $this->categories = $categories;
    }

    /**
     * @param Request $request
     * @param Products $Products
     * @return mixed
     */
    abstract public function execute(Request $request, Post $post);
}
