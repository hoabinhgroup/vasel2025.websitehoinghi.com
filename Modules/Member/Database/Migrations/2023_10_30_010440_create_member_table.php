<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('members', function (Blueprint $table) {
           $table->increments('id');
           $table->string('name', 191);
           $table->string('fullname', 250)->nullable();
           $table->string('email', 191)->unique();
           $table->string('password', 191)->nullable();
           $table->timestamp('email_verified_at')->nullable();
           $table->string('address', 250)->nullable();
           $table->string('phone', 50)->nullable();
           $table->string('website', 200)->nullable();
           $table->string('skype', 200)->nullable();
           $table->string('facebook', 200)->nullable();
           $table->string('remember_token', 100)->nullable();
           $table->tinyInteger('status')->unsigned()->default(1);
           $table->softDeletes();
           $table->timestamps();
        });
        
        Schema::create('member_registrations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('member_id');
            $table->integer('reference_id');
            $table->string('reference_type', 300);
            $table->string('status')->nullable();
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
        Schema::dropIfExists('members');
        Schema::dropIfExists('member_registrations');
    }
}
