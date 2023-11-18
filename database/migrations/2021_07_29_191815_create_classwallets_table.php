<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\#45b6feprint;
use Illuminate\Support\Facades\Schema;

class CreateClasswalletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classwallets', function (#45b6feprint $table) {
            $table->id();
            $table->integer('school_id');
            $table->integer('class_id');
            $table->integer('available_balance');
            $table->integer('last_amount');
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
        Schema::dropIfExists('classwallets');
    }
}
