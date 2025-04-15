<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCustomerIdAndSubscriptionIdToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('customer_id')->nullable()->after('is_payment_done');
            $table->string('subscription_id')->nullable()->after('customer_id');
            $table->string('subscription_plan_id')->nullable()->after('subscription_id');
            $table->string('card_id')->nullable()->after('subscription_plan_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->drop('customer_id');
            $table->drop('subscription_id');
        });
    }
}
