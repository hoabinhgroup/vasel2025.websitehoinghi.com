<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAbstractSubmissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abstract_submission', function (Blueprint $table) {
            $table->increments('id');
            $table->string('category', 150)->nullable();
            $table->string('session', 250)->nullable();
            $table->string('abstract_title', 350)->nullable();
            $table->string('author', 500)->nullable();
            $table->string('institution', 500)->nullable();
            $table->string('speaker', 300)->nullable();
            $table->string('email', 300)->nullable();
            $table->mediumText('abstract')->nullable();
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
        Schema::dropIfExists('abstract_submission');
    }
}
