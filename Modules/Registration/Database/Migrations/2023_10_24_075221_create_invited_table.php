<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvitedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('invited', function (Blueprint $table) {
            $table->increments('id');
            $table->string('guest_code', 150)->nullable();
            $table->string('title', 200);
            $table->string('fullname', 250);
            $table->string('passport', 300)->nullable();
            $table->string('expiryDate', 300)->nullable();
            $table->string('affiliation', 300)->nullable();
            $table->string('affiliation_address', 300)->nullable();
            $table->string('dietary', 300)->nullable();
            $table->string('country', 120)->nullable();
            $table->string('address', 300)->nullable();
            $table->string('mobiphone', 50);
            $table->string('email', 150);
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
        Schema::dropIfExists('invited');
    }
}
