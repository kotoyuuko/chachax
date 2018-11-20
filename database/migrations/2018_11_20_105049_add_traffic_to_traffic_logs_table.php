<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTrafficToTrafficLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('traffic_logs', function (Blueprint $table) {
            $table->decimal('traffic', 64, 4)->default(0)->after('downlink');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('traffic_logs', function (Blueprint $table) {
            $table->dropColumn('traffic');
        });
    }
}
