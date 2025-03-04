<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSliderTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create("sliders", function (Blueprint $table) {
      $table->increments("id");
      $table->string("name", 120);
      $table->string("key", 120);
      $table->string("description", 255)->nullable();
      $table->string("status", 60)->default(1);
      $table->timestamps();
    });

    Schema::create("slider_items", function (Blueprint $table) {
      $table->increments("id");
      $table->integer("slider_id", false, true);
      $table->string("title", 255);
      $table->string("image", 255);
      $table->string("link", 255)->nullable();
      $table->text("description")->nullable();
      $table
        ->integer("order")
        ->unsigned()
        ->default(0);
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
    Schema::dropIfExists("sliders");
    Schema::dropIfExists("slider_items");
  }
}
