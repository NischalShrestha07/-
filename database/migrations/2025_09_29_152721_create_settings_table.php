<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_name')->default('SurfsideMedia');
            $table->string('site_email')->default('contact@surfsidemedia.com');
            $table->string('site_logo')->nullable();
            $table->string('currency', 3)->default('USD');
            $table->string('currency_symbol', 10)->default('$');
            $table->decimal('tax_rate', 5, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('settings');
    }
};
