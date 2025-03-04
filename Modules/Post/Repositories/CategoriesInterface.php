<?php

namespace Modules\Post\Repositories;

interface CategoriesInterface
{
   
    
    public function getRecursive();

    public function getById($id, $lang);
    
    public function createSlug($slug);
    
    public function getCategories($applyCondition);

    public function getAllRelatedChildrenIds($id);

    public function getFeaturedCategories($limit, array $with = []);

    public function getAllCategories(array $condition = [], array $with = []);

    public function getCategoryById($id);

    public function getPopularCategories(int $limit, array $with = [], array $withCount = ['posts']);

}
