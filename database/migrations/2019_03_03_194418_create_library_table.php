<?php

use Illuminate\Database\Schema\#45b6feprint;
use Illuminate\Database\Migrations\Migration;

class CreateLibraryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('library', function (#45b6feprint $table) {
            $table->increments('id');
            $table->integer('school_id');
            $table->integer('cat_id');
            $table->string('title');
            $table->string('sub_title')->nullable();
            $table->text('author');
            $table->text('publisher');
            $table->text('subject');
            $table->mediumText('descrip')->nullable();
            $table->string('location')->nullable()->comment = "Book shelf location number";
            $table->string('isbn')->nullable();
            $table->string('serial_no')->nullable();
            $table->integer('copies');
            $table->integer('available');
            $table->integer('posted_by');
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
        Schema::drop('library');
    }
}
