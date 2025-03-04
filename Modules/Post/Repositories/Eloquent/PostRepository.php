<?php

namespace Modules\Post\Repositories\Eloquent;

use Modules\Base\Enums\BaseStatusEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\App;
use Modules\Base\Repositories\Eloquent\EloquentRepository;
use Modules\Post\Repositories\PostInterface;
use Illuminate\Support\Carbon;

class PostRepository extends EloquentRepository implements PostInterface
{
  /**
   * get model
   * @return string
   */
  public function getModel()
  {
    return \Modules\Post\Entities\Post::class;
  }

  public function getByCategory(
    $categoryId,
    $paginate = 12,
    $limit = 0,
    $page = 1
  ) {
    if (!is_array($categoryId)) {
      $categoryId = [$categoryId];
    }

    $data = $this->_model
      ->where("posts.status", BaseStatusEnum::PUBLISHED)
      ->join("post_categories", "post_categories.post_id", "=", "posts.id")
      ->join("categories", "post_categories.category_id", "=", "categories.id")
      ->whereIn("post_categories.category_id", $categoryId)
      ->select("posts.*")
      ->distinct()
      ->orderBy("posts.created_at", "desc");

    if ($paginate != 0) {
      return $this->applyBeforeQuery($data)->paginate(
        $paginate,
        ["*"],
        null,
        $page
      );
    }

    return $this->applyBeforeQuery($data)
      ->limit($limit)
      ->get();
  }

  public function getOtherPostsByCategory(
    $categoryId,
    $postId,
    $paginate = 12,
    $limit = 0,
    $page = 1
  ) {
    if (!is_array($categoryId)) {
      $categoryId = [$categoryId];
    }

    $data = $this->_model
      ->where("posts.status", BaseStatusEnum::PUBLISHED)
      ->join("post_categories", "post_categories.post_id", "=", "posts.id")
      ->join("categories", "post_categories.category_id", "=", "categories.id")
      ->whereIn("post_categories.category_id", $categoryId)
      ->where("posts.id", "<>", $postId)
      ->select("posts.*")
      ->distinct()
      ->orderBy("posts.created_at", "desc");

    if ($paginate != 0) {
      return $this->applyBeforeQuery($data)->paginate(
        $paginate,
        ["*"],
        null,
        $page
      );
    }

    return $this->applyBeforeQuery($data)
      ->limit($limit)
      ->get();
  }

  public function getFeatured(int $limit = 5, array $with = [])
    {
        $data = $this->_model
            ->where([
                'status'      => BaseStatusEnum::PUBLISHED,
                'is_featured' => 1,
            ])
            ->limit($limit)
            ->with($with)
            ->orderBy('created_at', 'desc');

        return $this->applyBeforeQuery($data)->get();
    }

    /**
     * {@inheritDoc}
     */
    public function getListPostNonInList(array $selected = [], $limit = 7, array $with = [])
    {
        $data = $this->_model
            ->where('status', BaseStatusEnum::PUBLISHED)
            ->whereNotIn('id', $selected)
            ->limit($limit)
            ->with($with)
            ->orderBy('created_at', 'desc');

        return $this->applyBeforeQuery($data)->get();
    }

     /**
     * {@inheritDoc}
     */
    public function getRelated($id, $limit = 3)
    {
        $data = $this->_model
            ->where('status', BaseStatusEnum::PUBLISHED)
            ->where('id', '!=', $id)
            ->limit($limit)
            ->orderBy('created_at', 'desc')
            ->whereHas('categories', function ($query) use ($id) {
                $query->whereIn('categories.id', $this->getRelatedCategoryIds($id));
            });

        return $this->applyBeforeQuery($data)->get();
    }

    /**
     * {@inheritDoc}
     */
    public function getRelatedCategoryIds($model)
    {
        $model = $model instanceof Eloquent ? $model : $this->find($model);

        if (!$model) {
            return [];
        }

        try {
            return $model->categories()->allRelatedIds()->toArray();
        } catch (Exception $exception) {
            return [];
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getByTag($tag, $paginate = 12)
    {
        $data = $this->_model
            ->with('slugable', 'categories', 'categories.slugable', 'author')
            ->where('status', BaseStatusEnum::PUBLISHED)
            ->whereHas('tags', function ($query) use ($tag) {
                /**
                 * @var Builder $query
                 */
                $query->where('tags.id', $tag);
            })
            ->orderBy('created_at', 'desc');

        return $this->applyBeforeQuery($data)->paginate($paginate);
    }

    /**
     * {@inheritDoc}
     */
    public function getRecentPosts($limit = 5, $categoryId = 0)
    {
        $data = $this->_model->where(['status' => BaseStatusEnum::PUBLISHED]);

        if ($categoryId != 0) {
            $data = $data->join('post_categories', 'post_categories.post_id', '=', 'posts.id')
                ->where('post_categories.category_id', $categoryId);
        }

        $data = $data->limit($limit)
            ->select('posts.*')
            ->orderBy('created_at', 'desc');

        return $this->applyBeforeQuery($data)->get();
    }

    /**
     * {@inheritDoc}
     */
    public function getSearch($query, $limit = 10, $paginate = 10)
    {
        $data = $this->_model->with('slugable')->where('status', BaseStatusEnum::PUBLISHED);
        foreach (explode(' ', $query) as $term) {
            $data = $data->where('name', 'LIKE', '%' . $term . '%');
        }

        $data = $data
            ->orderBy('created_at', 'desc');

        if ($limit) {
            $data = $data->limit($limit);
        }

        if ($paginate) {
            return $this->applyBeforeQuery($data)->paginate($paginate);
        }

        return $this->applyBeforeQuery($data)->get();
    }


    /**
     * {@inheritDoc}
     */
    public function getAllPosts($perPage = 12, $active = true, array $with = ['slugable'])
    {
        $data = $this->_model
            ->with($with)
            ->orderBy('created_at', 'desc');

        if ($active) {
            $data = $data->where('status', BaseStatusEnum::PUBLISHED);
        }

        return $this->applyBeforeQuery($data)->paginate($perPage);
    }

    /**
     * {@inheritDoc}
     */
    public function getPopularPosts($limit, array $args = [])
    {
        $data = $this->_model
            ->with('slugable')
            ->orderBy('views', 'desc')
            ->where('status', BaseStatusEnum::PUBLISHED)
            ->limit($limit);

        if (!empty(Arr::get($args, 'where'))) {
            $data = $data->where($args['where']);
        }

        return $this->applyBeforeQuery($data)->get();
    }

}
