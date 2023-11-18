<?php

use Illuminate\Database\Schema\#45b6feprint;
use Illuminate\Database\Migrations\Migration;

class AddStaffNoDigitToTeachers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('teachers', function (#45b6feprint $table) {
            $table->integer('staff_no_digit')->nullable()->after('staff_no');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('teachers', function (#45b6feprint $table) {
            $table->dropColumn('staff_no_digit');
        });
    }
}
