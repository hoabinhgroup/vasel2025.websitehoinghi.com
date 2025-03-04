<?php

namespace Modules\Page\Repositories\Eloquent;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\App;
use Modules\Base\Repositories\Eloquent\EloquentRepository;
use Modules\Page\Repositories\PageInterface;
use Illuminate\Support\Carbon;
use DB;

class PageRepository extends EloquentRepository implements PageInterface
{
	
	protected $screen = PAGE_SCREEN;
	
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
        return \Modules\Page\Entities\Page::class;
    }
  
    /**
     * @return mixed
     * @author Tuan Louis
     */
    public function getDataSiteMap()
    {
        $data = $this->_model->where('pages.status', 1)
            ->select('pages.*')
            ->orderBy('pages.created_at', 'desc');
        return $this->applyBeforeQuery($data)->get();
    }

    /**
     * @param $limit
     * @author Tuan Louis
     * @return $this
     */
    public function getFeaturedPages($limit)
    {
        $data = $this->_model->where(['pages.status' => 1, 'pages.featured' => 1])
            ->orderBy('pages.order', 'asc')
            ->select('pages.*')
            ->limit($limit)
            ->orderBy('pages.created_at', 'desc');
        return $this->applyBeforeQuery($data)->get();
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

    /**
     * @param $array
     * @param array $select
     * @return mixed
     * @author Tuan Louis
     */
    public function whereIn($array, $select = [])
    {
        $pages = $this->_model->whereIn('pages.id', $array)->where('pages.status', 1);
        if (empty($select)) {
            $select = 'pages.*';
        }
        $data = $pages->select($select)->orderBy('pages.order', 'ASC');
        return $this->applyBeforeQuery($data)->get();
    }

    /**
     * @param $query
     * @param int $limit
     * @return mixed
     * @author Tuan Louis
     */
    public function getSearch($query, $limit = 10)
    {
        $pages = $this->_model->where('pages.status', 1);
        foreach (explode(' ', $query) as $term) {
            $pages = $pages->where('pages.name', 'LIKE', '%' . $term . '%');
        }

        $data = $pages->select('pages.*')->orderBy('pages.created_at', 'desc')
            ->limit($limit);
        return $this->applyBeforeQuery($data)->get();
    }
    
    public function getPageBySlug($slug)
    {
	  /*  $page = DB::table('pages as p')	
 			->select('*')		
			->join('language_meta as l','l.lang_meta_content_id', '=', 'p.id')
			->join('slugs as s', 's.key', '=','p.slug')
			->where('p.slug', $slug )
			->where('l.lang_meta_reference', $this->screen)
			->first();
			*/
		$table = $this->_model->getTable();
		$page = $this->_model;
		
		$page = $this->_model->select("*")
			->where($table. '.slug', $slug )
			->join('slugs as s', 's.key', $table.'.slug');
			
		$page = $page->join('language_meta as l','l.lang_meta_content_id', $table. ".id");
		$page = $page->where('l.lang_meta_reference', $this->screen);
		$page = $page->first();
			
	

		return $page;	
    }

    /**
     * @param bool $active
     * @return mixed
     * @author Tuan Louis
     */
    public function getAllPages($active = true)
    {
        $data = $this->_model->select('pages.*');
        if ($active) {
            $data = $data->where(['pages.status' => 1]);
        }
        return $this->applyBeforeQuery($data)->get();
    }
    
    public function getAllPagesTrash($trash = true){
	     $data = $this->_model->select('pages.*');
         $data = $data->whereNotNull('pages.deleted_at')->withTrashed();
        return $this->applyBeforeQuery($data)->get();
    }
     
}
