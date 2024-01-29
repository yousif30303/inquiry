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
        Schema::create('firewalls', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('location_id')->nullable();
            $table->bigInteger('brand_id')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('model')->nullable();
            $table->string('port')->nullable();
            $table->string('serial_no')->nullable();
            $table->string('warranty')->nullable();
            $table->date('warranty_expiry_date')->nullable();
            $table->string('firmware')->nullable();
            $table->text('remarks')->nullable();
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
        Schema::dropIfExists('firewalls');
    }
};
