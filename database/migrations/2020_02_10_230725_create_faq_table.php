<?php

use Illuminate\Database\Schema\#45b6feprint;
use Illuminate\Database\Migrations\Migration;

class CreateFaqTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faq', function (#45b6feprint $table) {
            $table->increments('id');
            $table->text('title');
            $table->text('slug');
            $table->longText('content');
            $table->text('image1');
            $table->text('image2');
            $table->text('image3');
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
        Schema::drop('faq');
    }
}
