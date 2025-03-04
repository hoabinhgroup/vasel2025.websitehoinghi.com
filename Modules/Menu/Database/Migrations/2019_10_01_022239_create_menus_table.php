<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            Schema::create('menus', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name', 120);
            $table->string('slug', 120)->unique()->nullable();
            $table->boolean('status')->default(1);
            $table->softDeletes();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menus');
    }
}
