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
            $table->unsignedBigInteger('sub_category_id_1')->nullable()->after('category_id');
            $table->unsignedBigInteger('sub_category_id_2')->nullable()->after('sub_category_id_1');
            $table->unsignedBigInteger('sub_category_id_3')->nullable()->after('sub_category_id_2');

            $table->foreign('sub_category_id_1')->references('id')->on('categories');
            $table->foreign('sub_category_id_2')->references('id')->on('categories');
            $table->foreign('sub_category_id_3')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('advertisements', function (Blueprint $table) {
            $table->dropForeign(['sub_category_id_1']);
            $table->dropForeign(['sub_category_id_2']);
            $table->dropForeign(['sub_category_id_3']);
            $table->dropColumn(['sub_category_id_1', 'sub_category_id_2', 'sub_category_id_3']);
        });
    }
};
