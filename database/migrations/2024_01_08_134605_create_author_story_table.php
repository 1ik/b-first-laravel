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
        Schema::create('author_story', function (Blueprint $table) {
            $table->foreignId('author_id')->constrained('authors');
            $table->foreignId('story_id')->constrained('stories');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('author_story', function (Blueprint $table) {
            $table->dropForeign(['author_id']);
            $table->dropForeign(['story_id']);
            $table->dropIfExists();
        });
    }
};
