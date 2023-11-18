<?php

use Illuminate\Database\Schema\#45b6feprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agents', function (#45b6feprint $table) {
            $table->increments('id');
            $table->string('access');
            $table->string('fullname');
            $table->string('phone');
            $table->string('email')->unique();
            $table->boolean('status');
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
        Schema::drop('agents');
    }
}
