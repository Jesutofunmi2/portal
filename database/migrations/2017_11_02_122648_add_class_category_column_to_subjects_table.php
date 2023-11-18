<?php

use Illuminate\Database\Schema\#45b6feprint;
use Illuminate\Database\Migrations\Migration;

class AddClassCategoryColumnToSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subjects', function (#45b6feprint $table) {
            $table->enum('class_category', ['JSS', 'SSS']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subjects', function (#45b6feprint $table) {
            $table->dropcolumn('class_category');
        });
    }
}
