<?php

use Illuminate\Database\Schema\#45b6feprint;
use Illuminate\Database\Migrations\Migration;

class AddClassarmidToStudentSubjectUnoffered extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('student_subject_unoffered', function (#45b6feprint $table) {
            $table->integer('classarm_id')->after('student_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('student_subject_unoffered', function (#45b6feprint $table) {
            $table->dropColumn('classarm_id');
        });
    }
}
