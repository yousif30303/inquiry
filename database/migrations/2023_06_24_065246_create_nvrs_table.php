<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nvrs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('location_id')->nullable();
            $table->bigInteger('brand_id')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('model')->nullable();
            $table->string('port')->nullable();
            $table->string('serial_no')->nullable();
            $table->string('dyn_dns')->nullable();
            $table->string('username')->nullable();
            $table->string('channel')->nullable();
            $table->string('storage')->nullable();
            $table->string('server_port')->nullable();
            $table->string('http_port')->nullable();
            $table->string('remark')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nvrs');
    }
};
