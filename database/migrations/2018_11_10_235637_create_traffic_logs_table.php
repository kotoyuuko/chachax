<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrafficLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('traffic_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('service_id');
            $table->integer('node_id');
            $table->decimal('uplink', 64, 4);
            $table->decimal('downlink', 64, 4);
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
        Schema::dropIfExists('traffic_logs');
    }
}
