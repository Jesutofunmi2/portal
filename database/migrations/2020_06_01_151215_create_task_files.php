<?php

use Illuminate\Database\Schema\#45b6feprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskFiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_files', function (#45b6feprint $table) {
            $table->increments('id');
            $table->integer('task_id');
            $table->string('file_upload');
            $table->string('file_title');
            $table->string('file_number')->nullable();
            $table->string('file_type');
            $table->integer('upload_by');
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
        Schema::drop('task_files');
    }
}
