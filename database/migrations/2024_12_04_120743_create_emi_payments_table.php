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
        Schema::create('emi_payments', function (Blueprint $table) {
            $table->integer('id');
            $table->unsignedInteger('emi_installment_id');
            $table->decimal('amount', 10, 2);
            $table->string('trx_id');
            $table->string('sender_number');
            $table->enum('status', [
                'pending',
                'paid',
                'overdue',
                'processing',
                'canceled',
                'failed',
                'rejected',
            ]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emi_payments');
    }
};
