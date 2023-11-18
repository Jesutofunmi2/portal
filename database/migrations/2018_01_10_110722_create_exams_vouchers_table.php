<?php

use Illuminate\Database\Schema\#45b6feprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamsVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exams_vouchers', function (#45b6feprint $table) {
            $table->increments('id');
            $table->string('serial');
            $table->integer('pin1');
            $table->integer('pin2');
            $table->integer('pin3');
            $table->integer('pin4');
            $table->string('pin');
            $table->string('regnum')->unique()->nullable();
            $table->integer('school_id')->nullable();
            $table->integer('multiple');
            $table->string('exam_type');
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
        Schema::drop('exams_vouchers');
    }
}
