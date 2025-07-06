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
        Schema::create('camps', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100)->nullable(false);
            $table->string('description')->nullable(false);
            $table->datetime('start_date')->nullable();
            $table->datetime('end_date')->nullable();
            $table->string('main_image')->nullable();
            $table->string('address', 100)->nullable();
            $table->string('priceForGuests', 100)->nullable();
            $table->string('priceForMembers', 100)->nullable();
            $table->string('foodChoice')->nullable();
            $table->string('accommodation')->nullable();
            $table->string('clothing')->nullable();
            $table->string('worth')->nullable();
            $table->string('audience')->nullable();
            $table->bigInteger('programme_id')->unsigned()->index()->nullable();
            $table->foreign('programme_id')->references('id')->on('programmes');
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('camps');
    }
};
