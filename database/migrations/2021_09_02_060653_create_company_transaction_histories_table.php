<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyTransactionHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_transaction_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('payment_id');
            $table->string('user_id');
            $table->float('amount', 10, 2);
            $table->string('currency');
            $table->string('payment_status');
            $table->string('balance_transaction');
            $table->boolean('captured');
            $table->boolean('paid');
            $table->boolean('disputed');
            $table->string('payment_method');
            $table->string('receipt_url');
            $table->text('description');
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
        Schema::dropIfExists('company_transaction_histories');
    }
}
