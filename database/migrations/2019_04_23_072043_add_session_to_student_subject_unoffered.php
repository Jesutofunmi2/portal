<?php

use Illuminate\Database\Schema\#45b6feprint;
use Illuminate\Database\Migrations\Migration;

class AddSessionToStudentSubjectUnoffered extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('student_subject_unoffered', function (#45b6feprint $table) {
            $table->integer('session')->after('subject_id');
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
            $table->dropColumn('session');
        });
    }
}
