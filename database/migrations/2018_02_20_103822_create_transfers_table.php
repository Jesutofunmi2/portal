<?php

use Illuminate\Database\Schema\#45b6feprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfers', function (#45b6feprint $table) {
            $table->increments('id');
            $table->integer('student_former_id')->unsigned();
            $table->foreign('student_former_id')->references('id')->on('students')->onDelete('cascade');
            $table->integer('student_new_id')->unsigned()->nullable();
            $table->foreign('student_new_id')->references('id')->on('students')->onDelete('cascade');
            $table->integer('student_former_school')->unsigned();
            $table->foreign('student_former_school')->references('id')->on('schools')->onDelete('cascade');
            $table->integer('student_new_school')->unsigned()->nullable();
            $table->foreign('student_new_school')->references('id')->on('schools')->onDelete('cascade');
            $table->boolean('former_school_status')->default(0);
            $table->boolean('student_status')->default(0);
            $table->boolean('new_school_status')->default(0);
            $table->integer('session');
            $table->integer('class_id');
            $table->integer('classarm_id');
            $table->enum('term', ['First', 'Second', 'Third']);
            $table->string('former_principal_signature')->nullable();
            $table->string('new_principal_signature')->nullable();
            $table->text('reason_for_transfer');
            $table->integer('debtor_id')->unsigned()->nullable();
            $table->foreign('debtor_id')->references('id')->on('debtor_penalty')->onDelete('cascade');
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
        Schema::drop('transfers');
    }
}
