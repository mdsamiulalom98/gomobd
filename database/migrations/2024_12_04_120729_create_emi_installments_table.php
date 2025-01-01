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
        Schema::create('emi_installments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id');
            $table->decimal('amount', 10, 2);
            $table->decimal('paid_amount', 10, 2)->nullable();
            $table->enum('status', [
                'pending',
                'paid',
                'overdue',
                'processing',
                'canceled',
                'failed',
                'rejected',
            ]);
            $table->string('due_date');
            $table->string('payment_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emi_installments');
    }
};
