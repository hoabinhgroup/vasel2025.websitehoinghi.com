<?php

namespace Modules\Menu\Database\Seeders;

use Modules\Menu\Entities\Categories;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class SeedCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        
        $categories = [
	        [
		       'name' => 'Dien thoai',
		       'parent' => 0,
		       'description' => '',
		       'status' => 1,
		       'user_id' => 1,
		       'icon' => '',
		       'featured' => 0,
		       'position' => 0,
		       'is_default' => 0,
		       'deleted' => 0
	        ],
	         [
		       'name' => 'Laptop',
		       'parent' => 0,
		       'description' => '',
		       'status' => 1,
		       'user_id' => 1,
		       'icon' => '',
		       'featured' => 0,
		       'position' => 0,
		       'is_default' => 0,
		       'deleted' => 0
	        ],
        ];
        
        foreach($categories as $cat):
        Categories::insert([
			'name' => $cat['name'],
			'parent' => $cat['parent'],
			'description' => $cat['description'],
			'status' => $cat['status'],
			'user_id' => $cat['user_id'],
			'icon' => '',
		    'featured' => 0,
		    'position' => 0,
		    'is_default' => 0,
		    'deleted' => 0
		]);
		endforeach;
		
        // $this->call("OthersTableSeeder");
    }
}
