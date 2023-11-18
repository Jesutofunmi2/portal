<?php

use Illuminate\Database\Schema\#45b6feprint;
use Illuminate\Database\Migrations\Migration;

class CreateWalletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallets', function (#45b6feprint $table) {
            $table->increments('id');
            $table->integer('school_id');
            $table->float('cleared_balance', 24, 2)->default('0.00');
            $table->float('available_balance', 24, 2)->default('0.00');
            $table->float('last_payment', 24, 2)->default('0.00');
            $table->float('account_balance', 24, 2)->default('0.00');
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
        Schema::drop('wallets');
    }
}
