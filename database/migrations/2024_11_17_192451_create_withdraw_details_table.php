<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('withdraw_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('withdraw_id')->index();
            $table->integer('order_id')->index();
            $table->integer('amount')->length(6);
            $table->integer('commision')->length(6);
            $table->integer('shipping_charge')->length(6);
            $table->integer('payable_amount')->length(6);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdraw_details');
    }
};
