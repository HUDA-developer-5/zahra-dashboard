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
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chat_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('sender_id')->index();
            $table->unsignedBigInteger('receiver_id')->index();
            $table->unsignedTinyInteger('from_type')->comment('from admin or user');
            $table->text('message')->nullable();
            $table->string('type')->default('text');
            $table->unsignedBigInteger('offer_id')->nullable();
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_messages');
    }
};
