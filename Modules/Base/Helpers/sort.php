<?php

use Illuminate\Support\Collection;

if (!function_exists('sort_item_with_children')) {
    /**
     * Sort parents before children
     * @param Collection|array $list
     * @param array $result
     * @param int $parent
     * @param int $depth
     * @return array
     */
    function sort_item_with_children($list, $parent = null, $level = 0, array &$result = []): array
    {
        if ($list instanceof Collection) {
            $listArr = [];
            foreach ($list as $item) {
                $listArr[] = $item;
            }
            $list = $listArr;
        }
     
        foreach ($list as $key => $object) {
            if ((int)$object->parent == (int)$parent) {
                array_push($result, $object);
                $object->level = $level;
                unset($list[$key]);
                sort_item_with_children($list, $object->id, $level + 1, $result);
            }
        }
      

        return $result;
    }
}
