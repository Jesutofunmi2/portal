<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\#45b6feprint;
use Illuminate\Support\Facades\Schema;

class CreateOtpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('otps', function (#45b6feprint $table) {
            $table->id();
            $table->string('username');
            $table->string('otp');
            $table->string('expire');
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
        Schema::dropIfExists('otps');
    }
}
