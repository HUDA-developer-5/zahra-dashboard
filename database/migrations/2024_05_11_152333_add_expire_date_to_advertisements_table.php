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
        Schema::table('advertisements', function (Blueprint $table) {
            $table->unsignedBigInteger('payment_transaction_id')->nullable();
            $table->float('premium_amount')->nullable();
            $table->date('start_date')->nullable();
            $table->date('expire_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('advertisements', function (Blueprint $table) {
            $table->dropColumn(['payment_transaction_id', 'premium_amount', 'start_date', 'expire_date']);
        });
    }
};
