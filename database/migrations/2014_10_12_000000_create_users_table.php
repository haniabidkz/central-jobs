<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('address1');
            $table->string('address2');
            $table->integer('state_id')->unsigned();
            $table->integer('country_id')->unsigned();
            $table->integer('postal');
            $table->integer('telephone');
            $table->tinyInteger('status');
            $table->tinyInteger('approve_status');
            $table->softDeletes();  //added this line
            $table->rememberToken();
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
        Schema::dropIfExists('users');
        // $table->dropSoftDeletes(); //add this line
    }
}
