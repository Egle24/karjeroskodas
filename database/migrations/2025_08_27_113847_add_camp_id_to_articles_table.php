<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
    Schema::table('articles', function (Blueprint $table) {
        $table->foreignId('camp_id')
              ->nullable()
              ->constrained('camps')
              ->nullOnDelete(); // optional: set camp_id to null if camp is deleted
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropForeign(['camp_id']);
            $table->dropColumn('camp_id');
        });
    }
};
