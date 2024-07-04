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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('trainer_id');
            $table->timestamp('bought_at');
            $table->timestamp('expires_at');
            $table->string('price');
            $table->boolean('is_renewable');
            $table->timestamps();

            $table->foreign('trainer_id')->references('id')->on('users')->onDelete('cascade');

            $table->unique(['trainer_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
