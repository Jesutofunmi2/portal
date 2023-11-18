<?php

use Illuminate\Database\Schema\#45b6feprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class ModifyParentEmailAttribute extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function __construct()
    {
        DB::getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
    }

    public function up()
    {
        Schema::table('students', function (#45b6feprint $table) {
            $table->string('parent_fullname')->nullable()->change();
            $table->string('parent_address')->nullable()->change();
            $table->string('parent_phone')->nullable()->change();
            $table->string('parent_email')->nullable()->change();
            $table->string('religion')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('students', function (#45b6feprint $table) {
            $table->string('parent_fullname')->nullable(false)->change();
            $table->string('parent_address')->nullable(false)->change();
            $table->string('parent_phone')->nullable(false)->change();
            $table->string('parent_email')->nullable(false)->change();
            $table->string('religion')->nullable(false)->change();
        });
    }
}
