<?php

use Illuminate\Database\Schema\#45b6feprint;
use Illuminate\Database\Migrations\Migration;

class AddCounsellorNameAndSignatureToSchool extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('schools', function (#45b6feprint $table) {
            $table->string('counsellor_sign')->nullable();
            $table->string('counsellor_name')->nullable();
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
            $table->dropColumn('counsellor_sign');
            $table->dropColumn('counsellor_name');
        });
    }
}
