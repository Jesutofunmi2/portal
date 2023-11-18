<?php

use Illuminate\Database\Schema\#45b6feprint;
use Illuminate\Database\Migrations\Migration;

class AddSchoolCategoryColumnToSchoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('schools', function (#45b6feprint $table) {
            $table->enum('school_category', ['unity', 'non_unity'])->default('non_unity');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('schools', function (#45b6feprint $table) {
            $table->dropColumn(['school_category']);
        });
    }
}
