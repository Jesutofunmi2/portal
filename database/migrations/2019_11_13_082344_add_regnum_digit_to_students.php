<?php

use Illuminate\Database\Schema\#45b6feprint;
use Illuminate\Database\Migrations\Migration;

class AddRegnumDigitToStudents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('students', function (#45b6feprint $table) {
            $table->integer('regnum_digit')->nullable()->after('regnum');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('students', function (#45b6feprint $table) {
            $table->dropColumn('regnum_digit');
        });
    }
}
