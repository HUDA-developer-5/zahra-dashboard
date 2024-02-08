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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique()->index();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('phone_number')->nullable();
            $table->timestamp('phone_number_verified_at')->nullable();
            $table->string('type'); //(admin - teacher)
            $table->string('role')->nullable(); //(super admin - editor)
            $table->string('status'); //(active - blocked)
            $table->string('whatsapp_number')->nullable();
            $table->string('image')->nullable();
            $table->unsignedBigInteger('nationality_id')->nullable();
            $table->text('educations')->nullable();
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
