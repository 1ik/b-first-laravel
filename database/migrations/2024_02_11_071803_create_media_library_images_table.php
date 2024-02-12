<?php

use App\Constants\MediaStatus;
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
        Schema::create('media_library_images', function (Blueprint $table) {
            $table->id();
            $table->string('title')->index('title');
            $table->string('url');
            $table->text('meta');
            $table->enum('status', [MediaStatus::HIDDEN, MediaStatus::SHOWN])->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('media_library_images', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropIfExists();
        });
    }
};
