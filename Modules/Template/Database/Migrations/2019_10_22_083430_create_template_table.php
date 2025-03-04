<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTemplateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('templates', function (Blueprint $table) {
           $table->increments('id');
            $table->string('name', 120);
            $table->integer('user_id')->references('id')->on('users');
            $table->text('data')->nullable();
            $table->string('image', 255)->nullable();
            $table->string('color', 60)->nullable();
			$table->tinyInteger('sort')->default(0)->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('templates');
    }
}
