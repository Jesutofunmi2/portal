<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\#45b6feprint;
use Illuminate\Support\Facades\Schema;

class AddEmailVerifiedAtToSuperAdmins extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('super_admins', function (#45b6feprint $table) {
            $table->datetime('email_verified_at')->mullable();
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
            //
        });
    }
}
