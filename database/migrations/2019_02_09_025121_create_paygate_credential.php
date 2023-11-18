<?php

use Illuminate\Database\Schema\#45b6feprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaygateCredential extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paygate_credential', function (#45b6feprint $table) {
            $table->increments('id');
            $table->string('merchant');
            $table->string('data_type');
            $table->string('transfer')->nullable();
            $table->string('result_digi')->nullable();
            $table->string('cbt_pay')->nullable();
            $table->string('elibrary')->nullable();
            $table->string('advert')->nullable();
            $table->string('result_check')->nullable();
            $table->string('digi_card')->nullable();
        });


        // Insert data
        DB::table('paygate_credential')->insert(
            array(
                'merchant' => 'public',
                'data_type' => 'ID',
                'transfer' => '7007139440',
                'result_digi' => '7007139441',
                'cbt_pay' => '7007139442',
                'elibrary' => '7007139443',
                'advert' => '7007139449',
                'result_check' => '',
                'digi_card' => ''
            )
        );


        // Insert data
        DB::table('paygate_credential')->insert(
            array(
                'merchant' => 'public',
                'data_type' => 'KEY',
                'transfer' => 'Le9AuN32W0Gl0fnq',
                'result_digi' => 'wGKaAl9bGTgEL9g0',
                'cbt_pay' => 'mTr3MjvWF7bYiajQ',
                'elibrary' => 'pppRXm57SG9qePAT',
                'advert' => 'MztEZhhYFE1MwWzb',
                'result_check' => '',
                'digi_card' => ''
            )
        );

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('paygate_credential');
    }
}
