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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('target_user_id');
            $table->string('title_ar');
            $table->string('title_en');
            $table->string('action');
            $table->string('type');
            $table->boolean('is_read')->default(0);
            $table->string('status')->nullable();
            $table->unsignedBigInteger('advertisement_id')->nullable();
            $table->unsignedBigInteger('comment_id')->nullable();
            $table->json('payload')->nullable();
            $table->text('content_ar')->nullable();
            $table->text('content_en')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
