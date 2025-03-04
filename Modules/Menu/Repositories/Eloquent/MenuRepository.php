<?php

namespace Modules\Menu\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\App;
use Modules\Base\Repositories\Eloquent\EloquentRepository;
use Modules\Menu\Repositories\MenuInterface;
use Illuminate\Support\Carbon;
use Modules\Menu\Libraries\Recursive;

class MenuRepository extends EloquentRepository implements MenuInterface
{
	
	protected $screen = CATEGORY_NAME;
	
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
        return \Modules\Menu\Entities\Categories::class;
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
    
    public function getRecursive()
    {
	    $data = $this->_model->select($this->getTable() . '.*')->orderBy($this->getTable() . '.id', 'ASC');
        $data =  $this->applyBeforeQuery($data)->get()->toArray();	
	    return (new Recursive($data))->buildArray(0); 
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
    
    public function createSlug($slug)
    {
       
    }
    
    
    public function getCategories($applyCondition)
    {

	    $indent = '—';
                     
        $query = $this->select([$this->getTable() . '.*'], $applyCondition)
        				->orderBy($this->getTable() .'.id', 'ASC');
                      
       $data =  sort_item_with_children($query->get(), request()->category ?? 0);  
  
         foreach ($data as $item) {
            $indentText = '';
            $depth = (int)$item->level;
            for ($i = 0; $i < $depth; $i++) {
                $indentText .= $indent;
            }
            $item->indent_text = $indentText;
        } 
        
        return $data;

    }
}
