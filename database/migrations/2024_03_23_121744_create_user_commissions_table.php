<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_commissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('advertisement_id');
            $table->decimal('amount', 15);
            $table->decimal('commission', 15);
            $table->decimal('amount_after_commission', 15);
            $table->boolean('is_paid')->default(0);
            $table->unsignedBigInteger('payment_transaction_id')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_commissions');
    }
};
