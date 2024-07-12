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
        Schema::create('exercises', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('trainer_id');
            $table->unsignedBigInteger('user_id');
            $table->string('title');
            $table->text('description');
            $table->text('client_description')->nullable();
            $table->boolean('done')->nullable();
            $table->timestamp('done_at')->nullable();
            $table->integer('do_again_every')->nullable();
            $table->timestamps();

            $table->foreign('trainer_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exercises');
    }
};
