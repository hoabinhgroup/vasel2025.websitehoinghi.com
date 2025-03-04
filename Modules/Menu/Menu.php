<?php

namespace Modules\Menu;

use Modules\Base\Enums\BaseStatusEnum;
use Modules\Menu\Repositories\MenuInterface;
use Modules\Menu\Repositories\MenusInterface;
use Modules\Menu\Repositories\MenuNodeInterface;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Collective\Html\HtmlBuilder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Input;
use Modules\Menu\Libraries\Recursive;
use Modules\Base\Traits\CommonFunctions;
use Illuminate\Support\Arr;
use Schema;
use Theme;

class Menu
{
	use CommonFunctions;
    /**
     * @var mixed
     */
    protected $categories;

    protected $menu;

    protected $html;

    protected $menuNode;

    protected $langMeta;


    public function __construct(
        MenuInterface $categories,
        MenusInterface $menus,
        HtmlBuilder $html,
        MenuNodeInterface $menuNode
    )
    {
	    $this->categories = $categories;
	    $this->repository = $categories;
        $this->menu = $menus;
        $this->html = $html;
        $this->menuNode = $menuNode;

    }

     public function renderMenu($args = [])
    {

      $slug = get_array_value($args, 'slug');
      if(!$slug){
	     return null;
      }
      $template = get_array_value($args, 'view');
      if(!$template){
	     $template = 'menu-header';
      }
      $parent_id = get_array_value($args, 'parent_id');
      if(!$parent_id){
	     $parent_id = 0;
      }

      $level = get_array_value($args, 'level');
      if(!$level){
	     $level = 1;
      }


      $items = $this->menu->findByWhere(['slug' => $slug]);


      if(empty($items)){
	      return null;
      }

	 $nodes = $this->menuNode->getByAttributes([], ['menu_id' => $items->id, 'parent_id' => $parent_id], 'position');


	 $data = [];
	  foreach($nodes as $node):
		$data[] = $node;
	  endforeach;

	  $args['nodes'] = $data;
	  $args['level'] = $level;


	  return view( setting('theme') . '::partials.' . $template, ['data' => $args]);

    }


      public function generateSelect(array $args = [])
    {

        $model = Arr::get($args, 'model');
        $model = app()->make($model);
        if (!$model) {
            return null;
        }

        $view = Arr::get($args, 'view');
        $theme = Arr::get($args, 'theme', true);
        $type = Arr::get($args, 'type');



        $parentId = Arr::get($args, 'parent', 0);
        $active = Arr::get($args, 'active', true);
        $options = $this->html->attributes(Arr::get($args, 'options', []));

            if (!Arr::has($args, 'items')) {
                if (method_exists($model, 'children')) {
                    $items = $model->where('parent', $parentId)->with('children')->orderBy('name', 'asc');
                } else {

                    $items = $model->orderBy('name', 'asc');

                }
                if ($active) {
                    $items = $items->where('status', BaseStatusEnum::PUBLISHED);
                }

                $items = apply_filters(BASE_FILTER_BEFORE_GET_ADMIN_LIST_ITEM, $items, $model, $type)->get();

            } else {
                $items = Arr::get($args, 'items', []);
            }

            if (empty($items)) {
                return null;
            }

            $data = compact('items', 'model', 'options', 'type');


        if (!Arr::get($data, 'items') || ($data['items'] instanceof Collection && $data['items']->isEmpty())) {
            return null;
        }

        if ($theme && $view) {
            return view(setting('theme').'::'. $view, $data);
        }

        if ($view) {
            return view($view, $data)->render();
        }




        return view('menu::partials.select', $data)->render();
    }

  /*   public function recursive($root = 0)
    {

	    $data = $this->categories->getRecursive();

	    return (new Recursive($data))->buildArray($root);
    }
    */
}
