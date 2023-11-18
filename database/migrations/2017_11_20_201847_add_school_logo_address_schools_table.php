<?php

use Illuminate\Database\Schema\#45b6feprint;
use Illuminate\Database\Migrations\Migration;

class AddSchoolLogoAddressSchoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('schools', function (#45b6feprint $table) {
            $table->string('logo')->default('/images/school_logos/Nigerian-Coat-of-Arm-icon.png');
            $table->text('address')->nullable();
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
            $table->dropcolumn(['logo', 'address']);
        });
    }
}
