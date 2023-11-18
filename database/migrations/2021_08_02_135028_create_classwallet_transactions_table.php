<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\#45b6feprint;
use Illuminate\Support\Facades\Schema;

class CreateClasswalletTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classwallet_transactions', function (#45b6feprint $table) {
            $table->id();
            $table->integer('school_id');
            $table->integer('class_id');
            $table->integer('amount');
            $table->string('title');
            $table->mediumText('message');
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
        Schema::dropIfExists('classwallet_transactions');
    }
}
