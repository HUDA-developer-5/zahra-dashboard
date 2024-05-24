<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('premium_user_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class, 'user_id');
            $table->unsignedSmallInteger('premium_ads_percentage');
            $table->unsignedSmallInteger('premium_ads_count');
            $table->date('start_date');
            $table->date('end_date');
            $table->unsignedBigInteger('transaction_id')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('premium_user_subscriptions');
    }
};
