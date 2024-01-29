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
        Schema::create('outlets', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->bigInteger('location_id')->nullable();
            $table->bigInteger('brand_id')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('internet_type')->nullable();
            $table->string('provider')->nullable();
            $table->string('account_no')->nullable();
            $table->string('username')->nullable();
            $table->string('password')->nullable();
            $table->string('speed')->nullable();
            $table->string('monthly_rental')->nullable();
            $table->string('telephone')->nullable();
            $table->string('mobile')->nullable();
            $table->string('remarks')->nullable();
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
        Schema::dropIfExists('outlets');
    }
};
