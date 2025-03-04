<?php

namespace Modules\Base\Repositories;

interface RepositoryInterface
{
  public function make(array $with = []);

  public function getScreen(): string;

  public function getTable();

  public function applyBeforeQuery($data, $screen);
  /**
   * Get all
   * @return mixed
   */
  public function all();

  public function pluck($column, $key = null);

  public function allBy(
    array $condition,
    array $with = [],
    array $select = ["*"]
  );

  public function forceDelete(array $condition = []);

  public function restoreBy(array $condition = []);

  public function getFirstBy(
    array $condition = [],
    array $select = ["*"],
    array $with = []
  );

  public function getFirstByWithTrash(
    array $condition = [],
    array $select = []
  );

  /**
   * Get one
   * @param $id
   * @return mixed
   */
  public function find($id, array $with = []);

  public function findOrFail($id, array $with = []);

  public function findBy($attribute, $value, $columns = ["*"]);

  public function findByWhere(array $attributes = []);

  public function findByAttributes(array $attributes = []);

  public function getByAttributes(
    array $with = [],
    array $attributes = [],
    $orderBy = null,
    $sortOrder = "asc"
  );

  public function get_details(
    array $attributes = [],
    $orderBy = null,
    $sortOrder = "asc",
    array $with = []
  );
  /**
   * Create
   * @param array $attributes
   * @return mixed
   */
  public function create(array $attributes);
  
  public function firstOrCreate(array $data, array $with = []);

  /**
   * Update
   * @param $id
   * @param array $attributes
   * @return mixed
   */
  public function update($id, array $attributes);

  public function updateWhere(array $conditions, array $attributes);

  public function updateOrCreate(array $attributes, array $values = []);

  /**
   * Delete
   * @param $id
   * @return mixed
   */
  public function delete($id);

  public function delete_where(array $attributes = []);

  public function count(array $condition = []);

  public function getSubject($id);

  /*  public function select($option_fields = array(), $key = "id", $where = array(), $custom_key = ""); */
  //public function count(array $condition = []);
  function dropdown($option_fields = []);

  public function select(array $select = ["*"], array $condition = []);

  public function deleteBy(array $condition = []);

  public function advancedGet(array $params = []);
}
