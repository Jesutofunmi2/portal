<?php

use Illuminate\Database\Schema\#45b6feprint;
use Illuminate\Database\Migrations\Migration;

class AddPrincipalNameAndSignatureToSchool extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('schools', function (#45b6feprint $table) {
            $table->string('principal_sign')->nullable();
            $table->string('principal_name')->nullable();
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
            $table->dropColumn('principal_sign');
            $table->dropColumn('principal_name');
        });
    }
}
