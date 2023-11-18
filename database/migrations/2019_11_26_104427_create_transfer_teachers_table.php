<?php

use Illuminate\Database\Schema\#45b6feprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransferTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfers_teacher', function (#45b6feprint $table) {
            $table->increments('id');
            $table->integer('teacher_id')->unsigned();
            $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('cascade');
            $table->string('former_staff_no');
            $table->string('new_staff_no')->nullable();
            $table->integer('former_school')->unsigned();
            $table->foreign('former_school')->references('id')->on('schools')->onDelete('cascade');
            $table->integer('new_school')->unsigned()->nullable();
            $table->foreign('new_school')->references('id')->on('schools')->onDelete('cascade');
            $table->boolean('transfer_status')->default(0);
            $table->integer('session');
            $table->enum('term', ['First', 'Second', 'Third']);
            $table->text('reason_for_transfer');
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
        Schema::drop('transfers_teacher');
    }
}
