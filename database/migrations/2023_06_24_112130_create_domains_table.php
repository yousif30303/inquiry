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
        Schema::create('domains', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('service_provider')->nullable();
            $table->string('ser_pro_email')->nullable();
            $table->string('ser_pro_no')->nullable();
            $table->string('registeration_date')->nullable();
            $table->string('expire_date')->nullable();
            $table->string('domain_link')->nullable();
            $table->string('username')->nullable();
            $table->string('password')->nullable();
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
        Schema::dropIfExists('domains');
    }
};
