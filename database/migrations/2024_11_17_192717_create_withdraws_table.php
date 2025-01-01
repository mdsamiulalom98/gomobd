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
        Schema::create('withdraws', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('seller_id')->index()->length(8);
            $table->string('invoice_id')->index()->length(22);
            $table->integer('amount')->length(6);
            $table->string('payment_method')->length(25);
            $table->string('bank_name')->length(155)->nullable();
            $table->string('account_number')->length(20)->nullable();
            $table->string('routing_number')->length(20)->nullable();
            $table->string('receive_number')->length(20)->nullable();
            $table->string('admin_note')->length(155)->nullable();
            $table->string('status')->length(55);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdraws');
    }
};
