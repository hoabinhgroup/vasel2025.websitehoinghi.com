<?php

namespace Modules\Post\Supports;

use Modules\Post\Entities\Post;
use Modules\Post\Supports\Abstracts\StoreCategoryServiceAbstract;
use Illuminate\Http\Request;

class StoreCategoryService extends StoreCategoryServiceAbstract
{

    /**
     * @param Request $request
     * @param Post $post
     * @return mixed|void
     */
    public function execute(Request $request, Post $post)
    {
        $categories = $request->input('categories');       
            $post->categories()->detach();
            if (!empty($categories)) {
            foreach ($categories as $category) {
                $post->categories()->attach($category);
            }
        }
    }
}
