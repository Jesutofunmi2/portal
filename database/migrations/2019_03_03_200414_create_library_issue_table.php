<?php

use Illuminate\Database\Schema\#45b6feprint;
use Illuminate\Database\Migrations\Migration;

class CreateLibraryIssueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('library_issue', function (#45b6feprint $table) {
            $table->increments('id');
            $table->integer('school_id');
            $table->integer('book_id');
            $table->integer('issued_to');
            $table->date('issue_date');
            $table->date('due_date');
            $table->date('return_date')->default('0000-00-00');
            $table->tinyInteger('return_status')->default('1')->comment = "1 for Not Return, 2 for Returned, 3 for Overdue";
            $table->integer('issued_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('library_issue');
    }
}
