<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostTable extends Migration
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
            $table->string('name', 120);
            $table->integer('parent')->unsigned()->default(0);
            $table->string('description', 400)->nullable();
            $table->string('status', 60)->default('published');
            $table->integer('user_id');
            $table->string('icon', 60)->nullable();
            $table->tinyInteger('order')->default(0);
            $table->tinyInteger('is_featured')->default(0);
            $table->tinyInteger('is_default')->unsigned()->default(0);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('tags', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 120);
            $table->integer('author_id');
            $table->string('description', 400)->nullable()->default('');
            $table->integer('parent')->unsigned()->default(0);
            $table->string('status', 60)->default('published');
            $table->timestamps();
        });

        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255);
            $table->string('slug', 255);
            $table->string('description', 400)->nullable();
            $table->text('content')->nullable();
            $table->string('status', 60)->default('published');
            $table->integer('author_id');
            $table->tinyInteger('is_featured')->unsigned()->default(0);
            $table->string('image', 255)->nullable();
            $table->integer('views')->unsigned()->default(0);
            $table->string('format_type', 30)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('post_tags', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tag_id')->unsigned()->references('id')->on('tags')->onDelete('cascade');
            $table->integer('post_id')->unsigned()->references('id')->on('posts')->onDelete('cascade');
        });

        Schema::create('post_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->unsigned()->references('id')->on('categories')->onDelete('cascade');
            $table->integer('post_id')->unsigned()->references('id')->on('posts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('post_tags');
        Schema::dropIfExists('post_categories');
        Schema::dropIfExists('posts');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('tags');
    }
}
