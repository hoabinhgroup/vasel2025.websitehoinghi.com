<?php

namespace Modules\Menu\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Modules\Menu\Entities\Categories;
use Modules\Menu\Repositories\MenuInterface;
use Modules\Menu\Repositories\MenuNodeInterface;
use Menu;

class HookServiceProvider extends ServiceProvider
{
  /**
   * Register the service provider.
   *
   * @return void
   */
  public function boot()
  {
    // add_action(MENU_SIDEBAR, [$this, 'registerMenuOptions'], 1);
    //remove_filter(MENU_SIDEBAR_IMPORT);
    //add_filter(MENU_SIDEBAR_IMPORT, [$this, 'menuImport'], 20, 1);
    add_filter(MENU_SIDEBAR_IMPORT, [$this, "menuImport"], 20, 1);
  }

  /**
   * Register sidebar options in menu
   * @throws \Throwable
   */
  public function registerMenuOptions($model)
  {
    /*
	    $categories = DB::table('categories as c')
	 		->join('language_meta as l', 'l.lang_meta_content_id', '=', 'c.id')
	 		->where('l.lang_meta_code',$model->lang_meta_code)
	 		->where('l.lang_meta_reference',$this->app->make(MenuInterface::class)->getModel())->get()->toArray();

	 	$params = [
		 	'table' => $this->app->make(MenuInterface::class)->getTable(),
	 		'namespace' => $this->app->make(MenuInterface::class)->getModel(),
	 		'lang' => $model->lang_meta_code,
	 		'label' => "Menu"
	 		];

	 	$table = $params['table'];

	 	echo view('menu::cmspanel.partials.menu-options', compact('table','categories', 'params'));
*/
    /*
	   $pages = Menu::generateSelect([
            'model'   => $this->app->make(MenuInterface::class)->getModel(),
            'type'    => Categories::class,
            'theme'   => false,
            'options' => [
                'class' => 'list-item',
            ],
        ]);


        echo "<pre>";
        print_r(122);
        echo "</pre>"; die();

        echo view('page::partials.menu-options', compact('pages'));
*/
  }

  /*
    public function menuImport($request)
    {

		 	return $request;

	   	    $menu_id = $request['menu_id'] ?? 0;
		 	$namespace = $request['namespace'] ?? 0;
		 	$namespace = explode('_',$namespace);
		 	$namespace = "Modules\\". $namespace[0] . '\\Entities\\' .$namespace[1];
		 	$table = $request['table'];
		 	$lang = $request['lang'] ?? 0;
		 	$data = $request['data'] ?? 0;

	   		$final = array();
	   		if($data){
		 	foreach($data as $item):

		 	//$model = app(MenuInterface::class);
		 	//$menu = $model->getById($item, $lang)[0];
		  $menu = DB::table("$table as c")
	 		->join('language_meta as l', 'l.lang_meta_content_id', '=', 'c.id')
	 		->join('slugs as s', 's.reference_id', '=', 'c.id')
	 		->where('l.lang_meta_code',$lang)
	 		->where('l.lang_meta_reference',$namespace)
	 		->where('s.reference',$namespace)
	 		->where('c.id',$item)
	 		->first();

	 	//dd($menu);

	 		if($menu){
		 	$rows = array(
				 	'menu_id' =>  $menu_id,
				 	'parent_id' => '0',
				 	'related_id' => $item,
				 	'type' => $menu->lang_meta_reference,
				 	'url' => $menu->key,
				 	'title' => $menu->name,
				 	'target' => '_self',
				 	'has_child' => 0
			 	);

		 $return = app(MenuNodeInterface::class)->create($rows);
		// return $return->id;
		 }
		 	if($return){

		$menuNode = app(MenuNodeInterface::class)->find($return->id);							 $source = array_merge($menuNode->toArray(), [
					 'urlUpdate' => modal('/'.BACKEND ."/menunode/modal", "<i class='fa fa-pencil bigger-130 font-weight-bold'></i> Sửa", array("class" => "","data-keyboard" => 'false', "title" => "Sửa menu", "data-post-id" => $return->id )),
					 'urlDelete' => '<a onclick="deleteMenuNode(this);" class="red" data-url="/'. BACKEND ."/menunode/delete/". $return->id.'"><i class="fa fa-trash bigger-130"></i></a>'
				 ]);

			 	$final[] = array('data' => $source);
			 	}

		 	endforeach;
		 	}
		 return $final;
    }
*/

  public function menuImport($request)
  {
    $data = $request["menunodesadd"] ?? [];
    $final = [];
    if (!empty($data)) {
      foreach ($data as $item):
        $object = app()
          ->make($item["reference-type"])
          ->find($item["reference-id"]);

        $typeSlug = gettype($object->slug);
        if ($typeSlug == "object") {
          $slug = $object->slug->key;
        } else {
          $slug = $object->slug;
        }

        if ($object) {
          $rows = [
            "menu_id" => $request->menu_id,
            "parent_id" => "0",
            "related_id" => $item["reference-id"],
            "type" => $item["reference-type"],
            "url" => $slug,
            "title" => $object->name,
            "target" => "_self",
            "has_child" => 0,
          ];
        }
        $return = app(MenuNodeInterface::class)->create($rows);
        if ($return) {
          $menuNode = app(MenuNodeInterface::class)->find($return->id);
          $source = array_merge($menuNode->toArray(), [
            "urlUpdate" => modal(
              "/" . BACKEND . "/menunode/modal",
              "<i class='fa fa-pencil bigger-130 font-weight-bold'></i> Sửa",
              [
                "class" => "",
                "data-keyboard" => "false",
                "title" => "Sửa menu",
                "data-post-id" => $return->id,
              ]
            ),
            "urlDelete" =>
              '<a onclick="deleteMenuNode(this);" class="red" data-url="/' .
              BACKEND .
              "/menunode/delete/" .
              $return->id .
              '"><i class="fa fa-trash bigger-130"></i></a>',
          ]);

          $final[] = ["data" => $source];
        }
      endforeach;
    }
    return $final;
  }

  public function register()
  {
    //
  }

  /**
   * Get the services provided by the provider.
   *
   * @return array
   */
  public function provides()
  {
    return [];
  }
}
