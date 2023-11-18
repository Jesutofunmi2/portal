<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\#45b6feprint;
use Illuminate\Support\Facades\Schema;

class AddAllowStudentRegisterToAppConfig extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('app_config', function (#45b6feprint $table) {
            $table->string('allow_student_register')->default('true')->after('current_session');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('app_config', function (#45b6feprint $table) {
            $table->dropColumn('allow_student_register');
        });
    }
}
