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
        Schema::create('user_camps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained();
            $table->foreignId('camp_id')->constrained();
            $table->string('name');
            $table->string('surname');
            $table->string('phone_number');
            $table->string('email');
            $table->string('workplace');
            $table->enum('payment', ['manual', 'school'])->default('manual');
            $table->enum('invoice', ['pre_invoice', 'no', 'post_invoice'])->default('no');
            $table->enum('food_choice', ['everything', 'vegetarian_no_meat', 'vegetarian_fish_only', 'vegan']);
            $table->string('special_needs');
            $table->enum('paid', ['yes', 'no'])->default('no');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_camps');
    }
};
