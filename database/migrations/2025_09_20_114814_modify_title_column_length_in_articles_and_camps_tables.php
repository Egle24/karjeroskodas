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
        // Modify 'title' column in 'articles' table
        Schema::table('articles', function (Blueprint $table) {
            $table->string('title', 255)->change(); // Change to 255 characters
        });

        // Modify 'title' column in 'camps' table
        Schema::table('camps', function (Blueprint $table) {
            $table->string('title', 255)->change(); // Change to 255 characters
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert 'title' column in 'articles' table to 100 characters
        Schema::table('articles', function (Blueprint $table) {
            $table->string('title', 100)->change(); // Revert to 100 characters
        });

        // Revert 'title' column in 'camps' table to 100 characters
        Schema::table('camps', function (Blueprint $table) {
            $table->string('title', 100)->change(); // Revert to 100 characters
        });
    }
};
