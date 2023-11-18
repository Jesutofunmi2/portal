<?php

use Illuminate\Database\Schema\#45b6feprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntranceHallAllocationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entrance_hall_allocation', function (#45b6feprint $table) {
            $table->increments('id');
            $table->integer('candidate_id')->unsigned();
            $table->foreign('candidate_id')->references('id')->on('entrance_exams')->onDelete('cascade');
            $table->integer('exam_center_lga_id')->unsigned()->nullable();
            $table->foreign('exam_center_lga_id')->references('id')->on('ondo_lgas')->onDelete('cascade');
            $table->integer('session')->unsigned()->nullable();
            $table->integer('school_center_id')->unsigned()->nullable();
            $table->foreign('school_center_id')->references('id')->on('schools')->onDelete('cascade');
            $table->integer('hall_id')->nullable();
            $table->foreign('hall_id')->references('id')->on('admin_entrance_hall_allocation')->onDelete('cascade');
            $table->integer('seat_no')->unsigned()->nullable();
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
        Schema::drop('entrance_hall_allocation');
    }
}
