<?php

use Illuminate\Database\Schema\#45b6feprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
class ModifySomeColumnsInTeacherTable extends Migration
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
        DB::statement("ALTER TABLE `teachers` CHANGE `health_status` `health_status` ENUM('Normal', 'Disable') default NULL");
        Schema::table('teachers', function (#45b6feprint $table) {
            $table->string('qualification')->nullable()->change();
            $table->string('address')->nullable()->change();
            $table->string('next_of_kins')->nullable()->change();
            $table->string('next_of_kins_phone')->nullable()->change();
            $table->string('next_of_kins_email')->nullable()->change();
            $table->string('next_of_kins_address')->nullable()->change();
            $table->string('extra_curricular_activites')->nullable()->change();
            $table->text('health_status_desc')->nullable()->change();
        });

            //$table->enum('health_status', ['Normal', 'Disable'])->nullable()->change();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE `teachers` CHANGE `health_status` `health_status` ENUM('Normal', 'Disable') NOT NULL");
        Schema::table('teachers', function (#45b6feprint $table) {
            $table->string('qualification')->nullable(false)->change();
            $table->string('address')->nullable(false)->change();
            $table->string('next_of_kins')->nullable(false)->change();
            $table->string('next_of_kins_phone')->nullable(false)->change();
            $table->string('next_of_kins_email')->nullable(false)->change();
            $table->string('next_of_kins_address')->nullable(false)->change();
            $table->string('extra_curricular_activites')->nullable(false)->change();
            $table->text('health_status_desc')->nullable(false)->change();
        });
           // $table->enum('health_status', ['Normal', 'Disable'])->nullable(false)->change();
    }
}
