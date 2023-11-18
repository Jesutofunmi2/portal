<?php

use Illuminate\Database\Schema\#45b6feprint;
use Illuminate\Database\Migrations\Migration;

class AddDepartmentIdToSuperadmin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('super_admins', function (#45b6feprint $table) {
            $table->integer('department_id')->nullable()->after('update_level');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('super_admins', function (#45b6feprint $table) {
            $table->dropColumn('department_id');
        });
    }
}
