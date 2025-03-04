<?php

namespace Modules\Menu\Repositories;

//use Modules\Base\Repositories\RepositoryInterface;

interface MenuInterface
{
   
    
   // public function getSubject($id);
    
    public function getByLang($lang, $params = []);
    
    public function getRecursiveByLang($langSubject, $root = 0);
    
    public function getRecursive();

    public function getById($id, $lang);
    
    public function createSlug($slug);
    
    public function getCategories($applyCondition);

}
