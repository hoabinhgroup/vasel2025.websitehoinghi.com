<?php

namespace Modules\Post\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\App;
use Modules\Base\Enums\BaseStatusEnum;
use Modules\Base\Repositories\Eloquent\EloquentRepository;
use Modules\Post\Repositories\CategoriesInterface;
use Illuminate\Support\Carbon;
use Modules\Menu\Libraries\Recursive;

class CategoriesRepository extends EloquentRepository implements
  CategoriesInterface
{
  protected $screen = CATEGORIES_SCREEN;

  public function init()
  {
    parent::init();
  }
  /**
   * get model
   * @return string
   */
  public function getModel()
  {
    return \Modules\Post\Entities\Categories::class;
  }

  public function getRecursive()
  {
    $data = $this->_model
      ->select($this->getTable() . ".*")
      ->orderBy($this->getTable() . ".id", "ASC");
    $data = $this->applyBeforeQuery($data)
      ->get()
      ->toArray();
    return (new Recursive($data))->buildArray(0);
  }

  public function getById($id, $lang)
  {
    return array_filter(
      $this->getByAttributes(
        [
          "languageMeta" => function ($query) use ($lang) {
            $query->where("lang_meta_code", $lang);
          },
          "slug" => function ($query) {
            $query->where("reference", $this->screen);
          },
        ],
        ["id" => $id]
      )->toArray(),
      function ($param) {
        return $param["language_meta"] != "";
      }
    );
  }

  public function createSlug($slug)
  {
  }

  public function getCategories($applyCondition)
  {
    $indent = "—";

    $query = $this->select(
      [$this->getTable() . ".*"],
      $applyCondition
    )->orderBy($this->getTable() . ".id", "ASC");

    $data = sort_item_with_children($query->get(), request()->category ?? 0);

    foreach ($data as $item) {
      $indentText = "";
      $depth = (int) $item->level;
      for ($i = 0; $i < $depth; $i++) {
        $indentText .= $indent;
      }
      $item->indent_text = $indentText;
    }

    return $data;
  }

  public function getAllRelatedChildrenIds($id)
  {
    if (is_object($id)) {
      $model = $id;
    } else {
      $model = $this->getFirstBy(["categories.id" => $id]);
    }
    if (!$model) {
      return null;
    }

    $result = [];

    /* $children = $model->children()->select('categories.id')->get();

        foreach ($children as $child) {
            $result[] = $child->id;
            $result = array_merge($this->getAllRelatedChildrenIds($child), $result);
        }
        */
    $this->resetModel();

    return array_unique($result);
  }

  /**
     * {@inheritDoc}
     */
    public function getFeaturedCategories($limit, array $with = [])
    {
        $data = $this->_model
            ->with(array_merge(['slugable'], $with))
            ->where([
                'status'      => BaseStatusEnum::PUBLISHED,
                'is_featured' => 1,
            ])
            ->select([
                'id',
                'name',
                'description',
                'icon',
            ])
            ->orderBy('order')
            ->limit($limit);

        return $this->applyBeforeQuery($data)->get();
    }

    /**
     * {@inheritDoc}
     */
    public function getAllCategories(array $condition = [], array $with = [])
    {
        $data = $this->_model;
        if (!empty($condition)) {
            $data = $data->where($condition);
        }

        $data = $data
            ->where('status', BaseStatusEnum::PUBLISHED)
            ->orderBy('created_at', 'DESC')
            ->orderBy('order', 'DESC');

        if ($with) {
            $data = $data->with($with);
        }

        return $this->applyBeforeQuery($data)->get();
    }

    /**
     * {@inheritDoc}
     */
    public function getCategoryById($id)
    {
        $data = $this->_model->where([
            'id'     => $id,
            'status' => BaseStatusEnum::PUBLISHED,
        ]);

        return $this->applyBeforeQuery($data, true)->first();
    }
    

    /**
     * {@inheritDoc}
     */
    public function getPopularCategories(int $limit, array $with = [], array $withCount = ['posts'])
    {
        $data = $this->_model
            ->withCount($withCount)
            ->where('categories.status', BaseStatusEnum::PUBLISHED)
            ->limit($limit);

        return $this->applyBeforeQuery($data)->get();
    }
}
