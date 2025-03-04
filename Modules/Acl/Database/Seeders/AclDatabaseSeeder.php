<?php

namespace Modules\Acl\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Acl\Entities\Roles;

class AclDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
		$author = Roles::create([
            'name' => 'Phóng viên', 
            'slug' => 'author',
            'permissions' => [
                'menu.create' => true,
            ]
        ]);
        $editor = Roles::create([
            'name' => 'Biên tập viên', 
            'slug' => 'editor',
            'permissions' => [
                'menu.update' => true,
                'menu.publish' => true,
            ]
        ]);
        // $this->call("OthersTableSeeder");
    }
}
