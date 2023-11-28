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
        Schema::create('renstras', function (Blueprint $table) {
            $table->id();
            $table->string('vision')->nullable();
            $table->json('mission')->nullable();
            $table->json('iku')->nullable();
            $table->json('capaian')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('renstras');
    }
};
