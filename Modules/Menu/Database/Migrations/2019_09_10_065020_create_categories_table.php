<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
			$table->string('name');
			$table->integer('parent')->default(0);
			$table->text('description')->nullable();
			$table->tinyInteger('status')->default(0);
			$table->integer('user_id');
			$table->string('icon')->nullable();
			$table->tinyInteger('featured')->default(0);
			$table->integer('position')->default(0);
			$table->tinyInteger('is_default')->default(0);
			$table->tinyInteger('deleted')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
