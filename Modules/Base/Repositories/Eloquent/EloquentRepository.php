<?php

namespace Modules\Base\Repositories\Eloquent;

use Modules\Base\Repositories\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;

abstract class EloquentRepository implements RepositoryInterface
{
  /**
   * @var \Illuminate\Database\Eloquent\Model
   */
  protected $_model;

  protected $screen = "";

  protected $originalModel;

  /**
   * EloquentRepository constructor.
   */
  public function __construct()
  {
    $this->setModel();
  }

  /**
   * get model
   * @return string
   */
  abstract public function getModel();

  /**
   * Set model
   */

  public function getScreen(): string
  {
    return $this->screen;
  }

  public function setModel()
  {
    $this->_model = app()->make($this->getModel());

    $this->originalModel = app()->make($this->getModel());
  }

  public function resetModel()
  {
    $this->_model = new $this->originalModel();

    return $this;
  }

  public function getTable()
  {
    return $this->_model->getTable();
  }

  public function applyBeforeQuery($data, $isSingle = false)
  {
    if (is_backend()) {
      if (!$isSingle) {
        $data = apply_filters(
          BASE_FILTER_BEFORE_GET_ADMIN_LIST_ITEM,
          $data,
          $this->originalModel
        );
      } else {
        $data = apply_filters(
          BASE_FILTER_BEFORE_GET_ADMIN_SINGLE,
          $data,
          $this->originalModel
        );
      }
    } else {
      if (!$isSingle) {
        $data = apply_filters(
          BASE_FILTER_BEFORE_GET_FRONT_PAGE_ITEM,
          $data,
          $this->originalModel
        );
      } else {
        $data = apply_filters(
          BASE_FILTER_BEFORE_GET_SINGLE,
          $data,
          $this->originalModel
        );
      }
    }

    $this->resetModel();

    return $data;
  }

  public function make(array $with = [])
  {
    if (!empty($with)) {
      $this->_model = $this->_model->with($with);
    }
    return $this->_model;
  }

  /**
   * Get All
   * @return \Illuminate\Database\Eloquent\Collection|static[]
   */
  public function all(array $with = [], array $params = [])
  {
    $data = $this->make($with);

    $orderBy = get_array_value($params, "orderBy");
    $orderDir = get_array_value($params, "orderDir");
    if ($orderBy) {
      $data->orderBy("$orderBy", "$orderDir");
    } else {
      $data->orderBy($this->getTable() . ".id", "desc");
    }

    //return $data->get();
    return $this->applyBeforeQuery($data)->get();
  }

  public function pluck($column, $key = null)
  {
    $select = [$column];
    if (!empty($key)) {
      $select = [$column, $key];
    }

    $data = $this->_model->select($select);

    return $this->applyBeforeQuery($data)
      ->pluck($column, $key)
      ->all();
  }

  /**
   * {@inheritDoc}
   */
  public function allBy(
    array $condition,
    array $with = [],
    array $select = ["*"]
  ) {
    if (!empty($condition)) {
      $this->applyConditions($condition);
    }

    $data = $this->make($with)->select($select);

    return $this->applyBeforeQuery($data)->get();
  }

  /**
   * @param array $where
   * @param null|Eloquent|Builder $model
   */
  protected function applyConditions(array $where, &$model = null)
  {
    //$query = $this->_model;
    // $deleted_at = get_array_value($where, 'deleted_at');
    if (!$model) {
      $query = $this->_model;
    } else {
      $query = $model;
    }

    foreach ($where as $field => $value) {
      if (is_array($value)) {
        [$field, $condition, $val] = $value;
        switch (strtoupper($condition)) {
          case "IN":
            $query = $query->whereIn($field, $val);
            break;
          case "NOT_IN":
            $query = $query->whereNotIn($field, $val);
            break;
          default:
            $query = $query->where($field, $condition, $val);
            break;
        }
      } else {
        if ($field == "deleted_at") {
          $query = $query
            ->whereNotNull($this->getTable() . ".deleted_at")
            ->withTrashed();
        } else {
          $query = $query->where($field, "=", $value);
        }
      }
    }
    if (!$model) {
      $this->_model = $query;
    } else {
      $model = $query;
    }
  }

  /**
   * {@inheritDoc}
   */
  public function forceDelete(array $condition = [])
  {
    $this->applyConditions($condition);
    //updating
    $item = $this->_model->withTrashed()->first();
    if (!empty($item)) {
      $item->forceDelete();
    }
  }

  /**
   * {@inheritDoc}
   */
  public function restoreBy(array $condition = [])
  {
    $item = $this->_model
      ->where($condition)
      ->withTrashed()
      ->first();
    if (!empty($item)) {
      $item->restore();
    }
  }

  /**
   * {@inheritDoc}
   */
  public function getFirstBy(
    array $condition = [],
    array $select = ["*"],
    array $with = []
  ) {
    //$this->make($with);
    $data = $this->make($with);

    if (!empty($select)) {
      $data = $data
        ->where($condition)
        ->select($select)
        ->with($with);
    } else {
      $data = $data->where($condition);
    }

    return $this->applyBeforeQuery($data, true)->first();
  }

  /**
   * {@inheritDoc}
   */
  public function getFirstByWithTrash(array $condition = [], array $select = [])
  {
    $query = $this->_model->where($condition)->withTrashed();

    if (!empty($select)) {
      return $query->select($select)->first();
    }

    return $this->applyBeforeQuery($query, true)->first();
  }

  /**
   * Get one
   * @param $id
   * @return mixed
   */
  public function find($id, array $with = [])
  {
    $data = $this->make($with)->where($this->getTable() . ".id", $id);
    $data = $this->applyBeforeQuery($data, true);
    $data = $data->first();

    $this->resetModel();

    return $data;
  }

  /**
   * {@inheritDoc}
   */
  public function findOrFail($id, array $with = [])
  {
    $data = $this->make($with)->where("id", $id);
    $data = $this->applyBeforeQuery($data, true);
    $result = $data->first();
    $this->resetModel();

    if (!empty($result)) {
      return $result;
    }

    throw (new ModelNotFoundException())->setModel(
      get_class($this->originalModel),
      $id
    );
  }

  public function findBy($attribute, $value, $columns = ["*"])
  {
    $data = $this->_model->where($attribute, "=", $value);
    $data = $this->applyBeforeQuery($data, true);
    $data = $data->first($columns);

    $this->resetModel();
    return $data;
  }

  public function findByWhere(array $attributes = [])
  {
    $query = $this->_model;
    if (!empty($attributes)) {
      foreach ($attributes as $field => $value) {
        $query = $query->where($field, $value);
      }
    }
    $query = $this->applyBeforeQuery($query, true);
    return $query->first();
  }

  /**
   * @inheritdoc
   */
  public function findByAttributes(array $attributes = [])
  {
    $query = $this->_model;
    if (!empty($attributes)) {
      foreach ($attributes as $field => $value) {
        $query = $query->where($field, $value);
      }
    }
    //return $this->applyBeforeQuery($query)->first();
    //return $this->applyBeforeQuery($query, true)->first();
    $query = $this->applyBeforeQuery($query);
    return $query->first();
  }

  /**
   * @inheritdoc
   */
  public function getByAttributes(
    array $with = [],
    array $attributes = [],
    $orderBy = null,
    $sortOrder = "asc"
  ) {
    $query = $this->buildQueryByAttributes(
      $with,
      $attributes,
      $orderBy,
      $sortOrder
    );

    return $query->get();
  }

  /**
   * @inheritdoc
   */
  public function get_details(
    array $attributes = [],
    $orderBy = null,
    $sortOrder = "asc",
    array $with = []
  ) {
    $query = $this->buildQueryByAttributes(
      $with,
      $attributes,
      $orderBy,
      $sortOrder
    );

    return $query->get();
  }

  /**
   * Build Query to catch resources by an array of attributes and params
   * @param  array $attributes
   * @param  null|string $orderBy
   * @param  string $sortOrder
   * @return \Illuminate\Database\Eloquent\Builder
   */
  private function buildQueryByAttributes(
    array $with = [],
    array $attributes = [],
    $orderBy = null,
    $sortOrder = "asc"
  ) {
    $query = $this->make($with);

    if (!empty($attributes)) {
      foreach ($attributes as $field => $value) {
        $query = $query->where($field, $value);
      }
    }

    if (null !== $orderBy) {
      $query->orderBy($orderBy, $sortOrder);
    }

    return $query;
  }

  /**
   * Create
   * @param array $attributes
   * @return mixed
   */
  public function create(array $attributes)
  {
    return $this->_model->create($attributes);
  }

  /**
   * Update
   * @param $id
   * @param array $attributes
   * @return bool|mixed
   */
  public function update($id, array $attributes)
  {
    $result = $this->find($id);
    if ($result) {
      $result->update($attributes);
      return $result;
    }

    return false;
  }

  public function updateWhere(array $conditions, array $attributes)
  {
    $result = $this->findByWhere($conditions);
    if ($result) {
      $result->update($attributes);
      return $result;
    }

    return false;
  }

  /**
   * {@inheritDoc}
   */
  public function createOrUpdate($data, $condition = [])
  {
    /**
     * @var Model $item
     */
    if (is_array($data)) {
      if (empty($condition)) {
        $item = new $this->_model();
      } else {
        $item = $this->getFirstBy($condition);
      }
      if (empty($item)) {
        $item = new $this->_model();
      }

      $item = $item->fill($data);
    } elseif ($data instanceof Model) {
      $item = $data;
    } else {
      return false;
    }

    if ($item->save()) {
      $this->resetModel();
      return $item;
    }

    $this->resetModel();

    return false;
  }
  
  /**
   * {@inheritDoc}
   */
  public function firstOrCreate(array $data, array $with = [])
  {
      $data = $this->_model->firstOrCreate($data, $with);
  
      $this->resetModel();
  
      return $data;
  }

  /* public function updateOrCreate(array $attributes, array $values = [])
    {
       
        $model = $this->_model->updateOrCreate($attributes, $values);
        return $model;
    }*/

  public function updateOrCreate(array $attributes, array $values = [])
  {
    $model = $this->_model->updateOrCreate($attributes, $values);

    // $this->resetModel();
    return $model;
  }
  /**
   * Delete
   *
   * @param $id
   * @return bool
   */
  public function delete($id)
  {
    $result = $this->find($id);
    if ($result) {
      $result->delete();

      return true;
    }

    return false;
  }

  
  /**
   * Delete
   *
   * @param $attributes
   * @return bool
   */
  public function delete_where(array $attributes = [])
  {
    $result = $this->findByAttributes($attributes);
    if ($result) {
      $result->delete();

      return true;
    }

    return false;
  }

  /**
     * {@inheritDoc}
     */
    public function count(array $condition = [])
    {
        $this->applyConditions($condition);

        $data = $this->_model->count();

        $this->resetModel();

        return $data;
    }


  public function getSubject($id)
  {
    return array_values(
      array_filter(
        $this->getByAttributes([
          "languageMeta" => function ($query) use ($id) {
            $query->where("lang_meta_reference", $this->getScreen());
            $query->where("lang_meta_content_id", $id);
          },
          "slug" => function ($query) {
            $query->where("reference", $this->getScreen());
          },
        ])->toArray(),
        function ($param) {
          return $param["language_meta"] != "";
        }
      )
    )[0];
  }

  function selectbox(
    $option_fields = [],
    $key = "id",
    $where = [],
    $custom_key = ""
  ) {
    //  $where["deleted"] = 0;
    $list_data = [];
    $custom = "";
    $list_data = $this->_model->get()->toArray();
    $result = [];

    if (is_array($list_data) && count($list_data)) {
      foreach ($list_data as $data) {
        $text = "";
        foreach ($option_fields as $option) {
          $text .= $data[$option] . " ";
        }
        if ($custom_key != "") {
          $custom = "." . $data[$custom_key];
        }
        $result[$data[$key] . $custom] = $text;
      }
    }
    return $result;
  }

  function dropdown($option_fields = [])
  {
    //  $where["deleted"] = 0;
    $list_data = [];
    $list_data = $this->_model
      ->select($option_fields)
      ->get()
      ->toArray();
    return $list_data;
  }

  /**
   * {@inheritDoc}
   */
  public function select(array $select = ["*"], array $condition = [])
  {
    if (!empty($condition)) {
      $this->applyConditions($condition);
    }

    $data = $this->_model->select($select);

    // $data = $this->_model->where($condition)->select($select);

    return $this->applyBeforeQuery($data);
  }

  public function deleteBy(array $condition = [])
  {
    $this->applyConditions($condition);

    $data = $this->_model->get();

    if (empty($data)) {
      return false;
    }
    foreach ($data as $item) {
      $item->delete();
    }

    $this->resetModel();

    return true;
  }

   /**
     * {@inheritDoc}
     */
    public function advancedGet(array $params = [])
    {
        $params = array_merge([
            'condition' => [],
            'order_by'  => [],
            'take'      => null,
            'paginate'  => [
                'per_page'      => null,
                'current_paged' => 1,
            ],
            'select'    => ['*'],
            'with'      => [],
            'withCount' => [],
        ], $params);

        $this->applyConditions($params['condition']);

        $data = $this->_model;

        if ($params['select']) {
            $data = $data->select($params['select']);
        }

        foreach ($params['order_by'] as $column => $direction) {
            if (!in_array(strtolower($direction), ['asc', 'desc'])) {
                continue;
            }

            if ($direction !== null) {
                $data = $data->orderBy($column, $direction);
            }
        }

        if (!empty($params['with'])) {
            $data = $data->with($params['with']);
        }

        if (!empty($params['withCount'])) {
            $data = $data->withCount($params['withCount']);
        }

        if ($params['take'] == 1) {
            $result = $this->applyBeforeQuery($data, true)->first();
        } elseif ($params['take']) {
            $result = $this->applyBeforeQuery($data)->take((int)$params['take'])->get();
        } elseif ($params['paginate']['per_page']) {
            $paginateType = 'paginate';
            if (Arr::get($params, 'paginate.type') && method_exists($data, Arr::get($params, 'paginate.type'))) {
                $paginateType = Arr::get($params, 'paginate.type');
            }
            $result = $this->applyBeforeQuery($data)
                ->$paginateType(
                    (int)Arr::get($params, 'paginate.per_page', 10),
                    [$this->originalModel->getTable() . '.' . $this->originalModel->getKeyName()],
                    'page',
                    (int)Arr::get($params, 'paginate.current_paged', 1)
                );
        } else {
            $result = $this->applyBeforeQuery($data)->get();
        }

        return $result;
    }
}
