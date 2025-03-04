<?php

namespace Modules\Post\Repositories;

use Modules\Base\Repositories\RepositoryInterface;

interface PostInterface extends RepositoryInterface
{
	
   		public function getByCategory($categoryId, $paginate = 12, $limit = 0, $page = 1);
   		
   		public function getOtherPostsByCategory($categoryId, $postId, $paginate = 12, $limit = 0, $page = 1);

		public function getFeatured(int $limit = 5, array $with = []);

		public function getListPostNonInList(array $selected = [], $limit = 7, array $with = []);

		public function getRelated($id, $limit = 3);

		public function getRelatedCategoryIds($model);

		public function getByTag($tag, $paginate = 12);

		public function getRecentPosts($limit = 5, $categoryId = 0);

		public function getSearch($query, $limit = 10, $paginate = 10);

		public function getAllPosts($perPage = 12, $active = true, array $with = ['slugable']);

		public function getPopularPosts($limit, array $args = []);
}
