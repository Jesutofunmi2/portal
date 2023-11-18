<?php

use Illuminate\Database\Schema\#45b6feprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnityExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unity_exams', function (#45b6feprint $table) {
            $table->increments('id');
            $table->string('regnum')->unique()->nullable();
            $table->string('serial');
            $table->string('pin');
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
            $table->integer('agent_id')->unsigned()->nullable();
            $table->foreign('agent_id')->references('id')->on('agents')->onDelete('cascade');
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
        Schema::drop('unity_exams');
    }
}
