<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('bill_infos_tables', function (Blueprint $table) {
            $table->increments('id');
            $table->string('brand_name', 250);
            $table->string('brand_logo', 350)->default(null);
            $table->integer('due')->default(0);
            $table->string('due_info', 250)->default(null);
            $table->integer('brand_id')->default(0);
            $table->date('due_date');
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
        Schema::dropIfExists('apis');
    }
}
