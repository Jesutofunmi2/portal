<?php

use Illuminate\Database\Schema\#45b6feprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentComments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_comments', function (#45b6feprint $table) {
            $table->increments('id');
            $table->integer('student_id');
            $table->text('comment_house')->nullable();
            $table->text('comment_teacher')->nullable();
            $table->text('comment_guard')->nullable();
            $table->text('comment_principal')->nullable();
            $table->integer('session');
            $table->string('term');
            $table->integer('class_id');
            $table->integer('classarm_id');
            $table->integer('school_id');
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
        Schema::drop('student_comments');
    }
}
