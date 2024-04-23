<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  
    public function up(): void
    {
        // Adding 'created_by' and 'updated_by' columns to 'stories' table
        Schema::table('stories', function (Blueprint $table) {
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
        });

        // Adding 'created_by' and 'updated_by' columns to 'categories' table
        Schema::table('categories', function (Blueprint $table) {
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
        });

        // Adding 'created_by' and 'updated_by' columns to 'tags' table
        Schema::table('tags', function (Blueprint $table) {
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
        });

        // Adding 'created_by' and 'updated_by' columns to 'authors' table
        Schema::table('authors', function (Blueprint $table) {
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
        });
    }
    


    public function down(): void
    {
        Schema::table('tables', function (Blueprint $table) {
            
                // Dropping 'created_by' and 'updated_by' columns from 'stories' table
                Schema::table('stories', function (Blueprint $table) {
                    $table->dropColumn('created_by');
                    $table->dropColumn('updated_by');
                });

                // Dropping 'created_by' and 'updated_by' columns from 'categories' table
                Schema::table('categories', function (Blueprint $table) {
                    $table->dropColumn('created_by');
                    $table->dropColumn('updated_by');
                });

                // Dropping 'created_by' and 'updated_by' columns from 'tags' table
                Schema::table('tags', function (Blueprint $table) {
                    $table->dropColumn('created_by');
                    $table->dropColumn('updated_by');
                });

                // Dropping 'created_by' and 'updated_by' columns from 'authors' table
                Schema::table('authors', function (Blueprint $table) {
                    $table->dropColumn('created_by');
                    $table->dropColumn('updated_by');
                });
        });
    }
};
