<?php

use Illuminate\Database\Schema\#45b6feprint;
use Illuminate\Database\Migrations\Migration;

class CreateResultVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('result_vouchers', function (#45b6feprint $table) {
            $table->increments('id');
            $table->string('serial');
            $table->integer('pin1');
            $table->integer('pin2');
            $table->integer('pin3');
            $table->integer('pin4');
            $table->string('pin');
            $table->integer('student_id')->nullable();
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->integer('session')->nullable();
            $table->enum('term', ['First', 'Second', 'Third'])->nullable();
            $table->integer('class_id')->nullable();
            $table->foreign('class_id')->references('id')->on('classes')->onDelete('cascade');
            $table->integer('classarm_id')->nullable();
            $table->foreign('classarm_id')->references('id')->on('class_arms')->onDelete('cascade');
            $table->softDeletes();
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
        Schema::drop('result_vouchers');
    }
}
