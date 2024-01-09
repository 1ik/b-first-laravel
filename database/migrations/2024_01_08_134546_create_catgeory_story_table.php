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
        Schema::create('category_story', function (Blueprint $table) {
            $table->foreignId('category_id')->constrained('categories');
            $table->foreignId('story_id')->constrained('stories');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('category_story', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropForeign(['story_id']);
            $table->dropIfExists();
        });
    }
};
