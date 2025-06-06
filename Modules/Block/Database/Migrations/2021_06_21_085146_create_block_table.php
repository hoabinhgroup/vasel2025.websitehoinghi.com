<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlockTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create("blocks", function (Blueprint $table) {
      $table->increments("id");
      $table->string("name");
      $table->string("alias");
      $table->string("description", 255)->nullable();
      $table->text("content")->nullable();
      $table->string("status", 60)->default("published");
      $table
        ->integer("user_id")
        ->unsigned()
        ->nullable()
        ->references("id")
        ->on("users")
        ->onDelete("set null");
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
    Schema::dropIfExists("blocks");
  }
}
