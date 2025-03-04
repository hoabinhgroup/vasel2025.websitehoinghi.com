<?php

namespace Modules\Menu\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\App;
use Modules\Base\Repositories\Eloquent\EloquentRepository;
use Modules\Menu\Repositories\MenusInterface;
use Illuminate\Support\Carbon;
use Modules\Menu\Libraries\Recursive;

class MenusRepository extends EloquentRepository implements MenusInterface
{
	protected $screen = MENU_NAME;
	
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
        return \Modules\Menu\Entities\Menu::class;
    }
    
    public function getByLang($lang, $params = [])    
    {
	    $screen = $this->screen;
	   return array_filter($this->getByAttributes([
	  		'languageMeta' => function($query) use ($lang, $screen){
		  		$query->where('lang_meta_code', $lang);
		  		$query->where('lang_meta_reference', $screen);
	    			},
	    	'slug' => function($query) use ($screen){
		    	$query->where('reference', $screen);
	    			}])->toArray(), function($param){
		    			return $param['language_meta'] != '';
	    			});	    				    					
    }
    
    public function getRecursiveByLang($langSubject, $root = 0)
    {
	    $parent = $this->getByLang($langSubject);

	    return (new Recursive($parent))->buildArray($root); 
    }
    
    public function getById($id, $lang)    
    {
	  return array_filter($this->getByAttributes([
	 	'languageMeta' => function($query) use ($lang){
		    	$query->where('lang_meta_code', $lang);
	    			},
	 	'slug' => function($query){
		    	$query->where('reference', $this->screen);
	    			}], ['id' => $id])
	    			->toArray(), function($param){
		    			return $param['language_meta'] != '';
	    			});
    }
   
}
