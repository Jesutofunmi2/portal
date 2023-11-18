<?php

use Illuminate\Database\Schema\#45b6feprint;
use Illuminate\Database\Migrations\Migration;

class AddTitleAndmaritalStatusColumnToTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('teachers', function (#45b6feprint $table) {
            $table->string('title')->after('id')->nullable();
            $table->enum('marital_status', ['Single', 'Divorce', 'Married'])->after('middlename')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('teachers', function (#45b6feprint $table) {
            $table->dropColumn(['marital_status', 'title']);
        });
    }
}
