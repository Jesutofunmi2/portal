<?php

use Illuminate\Database\Schema\#45b6feprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminUnityHallAllocationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_unity_hall_allocation', function (#45b6feprint $table) {
            $table->increments('id');
            $table->string('hall');
            $table->integer('exam_center_lga_id')->unsigned();
            $table->foreign('exam_center_lga_id')->references('id')->on('ondo_lgas')->onDelete('cascade');
            $table->integer('session')->unsigned();
            $table->integer('school_center_id')->unsigned()->nullable();
            $table->foreign('school_center_id')->references('id')->on('schools')->onDelete('cascade');
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
        Schema::drop('admin_unity_hall_allocation');
    }
}
