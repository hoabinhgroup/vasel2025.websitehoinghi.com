<?php

namespace Modules\Post\Supports;

use Modules\Base\Events\CreatedContentEvent;
use Modules\Post\Entities\Post;
use Modules\Post\Supports\Abstracts\StoreTagServiceAbstract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class StoreTagService extends StoreTagServiceAbstract
{

    /**
     * @param Request $request
     * @param Post $post
     * @return mixed|void
     */
    public function execute(Request $request, Post $post)
    {
        $tags = $post->tags->pluck('name')->all();

        $tagsInput = collect(json_decode($request->input('tag'), true))->pluck('value')->all();

        if (count($tags) != count($tagsInput) || count(array_diff($tags, $tagsInput)) > 0) {
            $post->tags()->detach();
            foreach ($tagsInput as $tagName) {

                if (!trim($tagName)) {
                    continue;
                }

                $tag = $this->tag->findByWhere(['name' => $tagName]);

                if ($tag === null && !empty($tagName)) {
                    $tag = $this->tag->updateOrCreate([
                        'name'      => $tagName,
                        'author_id' => Auth::user()->getKey(),
                    ]);

                    $request->merge(['slug' => Str::slug($tagName)]);

                    event(new CreatedContentEvent($request, $tag));
                }

                if (!empty($tag)) {
                    $post->tags()->attach($tag->id);
                }
            }
        }
    }
}
