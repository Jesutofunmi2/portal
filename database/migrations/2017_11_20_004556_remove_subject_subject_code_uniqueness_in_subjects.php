<?php

use Illuminate\Database\Schema\#45b6feprint;
use Illuminate\Database\Migrations\Migration;

class RemoveSubjectSubjectCodeUniquenessInSubjects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subjects', function (#45b6feprint $table) {
            $table->dropUnique('subjects_subject_name_unique');
            $table->dropUnique('subjects_subject_code_unique');

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
            $table->unique('subject_name');
            $table->unique('subject_code');
            
        });
    }
}
