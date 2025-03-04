<?php

namespace Modules\Menu\Repositories;


interface MenusInterface
{
     public function getByLang($lang, $params = []);
    
    public function getRecursiveByLang($langSubject, $root = 0);
    
    public function getById($id, $lang);
}
