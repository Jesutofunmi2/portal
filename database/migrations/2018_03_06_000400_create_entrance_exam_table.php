<?php

use Illuminate\Database\Schema\#45b6feprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntranceExamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entrance_exams', function (#45b6feprint $table) {
            $table->increments('id');
            $table->string('regnum')->unique()->nullable();
            $table->integer('card_id')->nullable();
            $table->foreign('card_id')->references('id')->on('exams_vouchers')->onDelete('cascade');
            $table->integer('school_id')->nullable();
            $table->foreign('school_id')->references('id')->on('primary_schools')->onDelete('cascade');
            $table->string('password')->nullable();
            $table->string('surname')->nullable();
            $table->string('firstname')->nullable();
            $table->string('middlename')->nullable();
            $table->enum('gender',['Male', 'Female'])->nullable();
            $table->enum('blood_group',['O+', 'O-','A+', 'A-','B+', 'B-','AB+', 'AB-'])->nullable();
            $table->date('dob')->nullable();
            $table->string('address')->nullable();
            $table->string('country')->nullable();
            $table->integer('state_id')->unsigned()->nullable();
            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
            $table->integer('lga_id')->unsigned()->nullable();
            $table->foreign('lga_id')->references('id')->on('lgas')->onDelete('cascade');
            $table->string('parent_fullname')->nullable();
            $table->string('parent_address')->nullable();
            $table->string('parent_phone')->nullable();
            $table->string('parent_email')->nullable();
            $table->string('phone')->nullable();
            $table->integer('session')->index()->nullable();
            $table->string('religion')->nullable();
            $table->string('passport')->nullable();
            $table->integer('first_choice')->unsigned()->nullable();
            $table->foreign('first_choice')->references('id')->on('schools')->onDelete('cascade');
            $table->integer('second_choice')->unsigned()->nullable();
            $table->foreign('second_choice')->references('id')->on('schools')->onDelete('cascade');
            $table->boolean('submitted')->default(0);
            $table->rememberToken();
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
        Schema::drop('entrance_exams');
    }
}
