<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegistrationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('registrations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('guest_code', 150)->nullable();
            $table->string('title', 300);
            $table->string('fullname', 250);
            $table->string('jobtitle', 250);
            $table->string('department', 300);
            $table->string('country', 120)->nullable();
            $table->string('address', 300)->nullable();
            $table->string('mobiphone', 50);
            $table->string('email', 150);
            $table->string('conference_fees', 500);
            $table->string('total_fees', 500);
            $table->string('attach', 350)->nullable();
            $table->tinyInteger('payment_method')->default(0);
            $table->string('orderinfo', 250)->nullable();
            $table->string('vpc_TransactionNo', 300)->nullable();
            $table->tinyInteger('status')->nullable();
            $table->string('txnResponseCode', 300)->nullable();
            $table->tinyInteger('checkin')->default(0);
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
        Schema::dropIfExists('registrations');
    }
}
