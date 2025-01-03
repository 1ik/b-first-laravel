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
        Schema::table('users', function (Blueprint $table) {
            $table->string('is_public')->after('remember_token')->default(0);
            $table->string('avatar')->after('remember_token')->nullable();
            $table->string('provider', 20)->after('remember_token')->nullable();
            $table->string('provider_id')->after('remember_token')->nullable();
            $table->text('access_token')->after('remember_token')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_public');
            $table->dropColumn('avatar');
            $table->dropColumn('provider');
            $table->dropColumn('provider_id');
            $table->dropColumn('access_token');
        });
    }
};
