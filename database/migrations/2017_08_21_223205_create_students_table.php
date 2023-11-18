<?php

use Illuminate\Database\Schema\#45b6feprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (#45b6feprint $table) {
            $table->increments('id');
            $table->string('regnum')->unique()->nullable();
            $table->string('surname');
            $table->string('firstname');
            $table->string('middlename')->nullable();
            $table->enum('gender',['Male', 'Female']);
            $table->date('dob')->nullable();
            $table->string('address');
            $table->string('country');
            $table->integer('state_id')->unsigned();
            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
            $table->integer('lga_id')->unsigned();
            $table->foreign('lga_id')->references('id')->on('lgas')->onDelete('cascade');
            $table->integer('school_id')->unsigned();
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
            $table->string('parent_fullname');
            $table->string('parent_address');
            $table->string('parent_phone');
            $table->string('parent_email');
            $table->string('phone')->nullable();
            $table->integer('session');
            $table->boolean('status');
            $table->integer('house_id')->nullable();
            $table->foreign('house_id')->references('id')->on('student_houses')->onDelete('cascade');
            $table->string('religion');
            $table->string('password');
            $table->string('passport')->default('/images/passports/no_img_da88a72526.gif');
            $table->rememberToken();
            $table->timestamps();
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
        Schema::drop('students');
    }
}
