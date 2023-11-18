<?php

use Illuminate\Database\Schema\#45b6feprint;
use Illuminate\Database\Migrations\Migration;

class AddPayChannelToPaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payment', function (#45b6feprint $table) {
            $table->string('pay_channel', 50)->after('recipient_count')->comment = "Payoutlet, Webconnect, Bankit";
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payment', function (#45b6feprint $table) {
            $table->dropColumn('pay_channel');
        });
    }
}
