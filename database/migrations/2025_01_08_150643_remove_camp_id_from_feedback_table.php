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
        Schema::table('feedback', function (Blueprint $table) {
            $table->dropForeign('feedback_camp_id_foreign'); // Drop the foreign key
            $table->dropColumn('camp_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('feedback', function (Blueprint $table) {
            $table->unsignedBigInteger('camp_id')->nullable();
            $table->foreign('camp_id')->references('id')->on('camps'); // Restore the foreign key

        });
    }
};
