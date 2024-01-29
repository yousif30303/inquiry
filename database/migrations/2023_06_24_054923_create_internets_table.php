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
        Schema::create('internets', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('location_id')->nullable();
            $table->string('type')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('provider')->nullable();
            $table->string('account')->nullable();
            $table->string('username')->nullable();
            $table->string('password')->nullable();
            $table->string('speed')->nullable();
            $table->string('router')->nullable();
            $table->string('monthly_rental')->nullable();
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
        Schema::dropIfExists('internets');
    }
};
