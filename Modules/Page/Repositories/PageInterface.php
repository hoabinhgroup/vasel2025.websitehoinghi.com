<?php

namespace Modules\Page\Repositories;

//use Modules\Base\Repositories\RepositoryInterface;

interface PageInterface
{
   
/**
     * @return mixed
     * @author Tuan Louis
     */
    public function getDataSiteMap();

    /**
     * @param $limit
     * @author Tuan Louis
     */
    public function getFeaturedPages($limit);


	public function getById($id, $lang);
    /**
     * @param $array
     * @param array $select
     * @return mixed
     * @author Tuan Louis
     */
    public function whereIn($array, $select = []);

    /**
     * @param $query
     * @param int $limit
     * @return mixed
     * @author Tuan Louis
     */
    public function getSearch($query, $limit = 10);


	public function getPageBySlug($slug);
    /**
     * @param bool $active
     * @return mixed
     * @author Tuan Louis
     */
    public function getAllPages($active = true);
    
    public function getAllPagesTrash($delete = true);
}
