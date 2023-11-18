<?php

use Illuminate\Database\Schema\#45b6feprint;
use Illuminate\Database\Migrations\Migration;

class AddPromotionToStudentResults extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('student_results', function (#45b6feprint $table) {
            $table->tinyInteger('promotion')->after('school_id')->default(1)->comment = "1 for Unspecified, 2 for Promoted, 3 for Repeat";
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('student_results', function (#45b6feprint $table) {
            $table->dropColumn('promotion');
        });
    }
}
