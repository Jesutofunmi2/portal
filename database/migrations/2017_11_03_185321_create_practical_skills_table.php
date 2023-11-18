<?php

use Illuminate\Database\Schema\#45b6feprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreatePracticalSkillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('practical_skills', function (#45b6feprint $table) {
            $table->increments('id');
            $table->integer('student_id')->unsigned();
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->boolean('status')->default(0);
            $table->integer('session')->index();
            $table->enum('term', ['First', 'Second', 'Third']);
            $table->integer('class_id')->unsigned();
            $table->foreign('class_id')->references('id')->on('classes')->onDelete('cascade');
            $table->integer('classarm_id')->unsigned();
            $table->foreign('classarm_id')->references('id')->on('class_arms')->onDelete('cascade');
            $table->integer('school_id')->unsigned()->index();
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
            $table->enum('hand_writing', [0, 1, 2, 3, 4, 5]);
            $table->enum('music', [0, 1, 2, 3, 4, 5]);
            $table->enum('drama', [0, 1, 2, 3, 4, 5]);
            $table->enum('craft', [0, 1, 2, 3, 4, 5]);
            $table->enum('club_societies', [0, 1, 2, 3, 4, 5]);
            $table->enum('hobbies', [0, 1, 2, 3, 4, 5]);
            $table->enum('sports', [0, 1, 2, 3, 4, 5]);
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->index(['school_id', 'session']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('practical_skills');
    }
}
