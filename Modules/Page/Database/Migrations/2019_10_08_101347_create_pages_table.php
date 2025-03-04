<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create("pages", function (Blueprint $table) {
      $table->increments("id");
      $table->string("name", 250);
      $table->string("slug", 250);
      $table->text("content");
      $table->string("status", 60)->nullable();
      $table
        ->integer("user_id")
        ->references("id")
        ->on("users");
      $table->string("image", 255)->nullable();
      $table->string("template", 60)->nullable();
      $table
        ->integer("parent")
        ->unsigned()
        ->index()
        ->default(0);
      $table->string("icon", 60)->nullable();
      $table->tinyInteger("featured")->default(0);
      $table
        ->tinyInteger("order")
        ->default(0)
        ->nullable();
      $table->string("description", 400)->nullable();
      $table->softDeletes();
      $table->timestamps();
      $table->engine = "InnoDB";
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists("pages");
  }
}
