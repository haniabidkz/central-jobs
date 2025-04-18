<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PasswordReset extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('password_resets')) {
            Schema::table('password_resets', function (Blueprint $table) {
                $table->timestamp('updated_at')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('password_resets')) {
            if (Schema::hasColumn('password_resets', 'updated_at')) {
                Schema::table('password_resets', function (Blueprint $table) {
                    $table->dropColumn('updated_at');
                });
            }
        }
    }
}
