<?php

use Illuminate\Database\Schema\#45b6feprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (#45b6feprint $table) {
            $table->increments('id');
            $table->integer('department_id');
            $table->string('title');
            $table->date('start_date');
            $table->date('due_date');
            $table->mediumText('descrip')->nullable();
            $table->tinyInteger('task_status')->comment = "1 - Pending, 2 - In-progress, 3 - Completed, 4 - Abandoned";
            $table->tinyInteger('approved')->comment = "1 - false, 2 - true";
            $table->integer('posted_by');
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
        Schema::drop('tasks');
    }
}
