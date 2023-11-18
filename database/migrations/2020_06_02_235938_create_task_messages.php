<?php

use Illuminate\Database\Schema\#45b6feprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskMessages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_messages', function (#45b6feprint $table) {
            $table->increments('id');
            $table->integer('task_id');
            $table->integer('commenter_id');
            $table->mediumText('comment');
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
        Schema::drop('task_messages');
    }
}
