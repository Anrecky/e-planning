<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sbmsbis', function (Blueprint $table) {
            $table->id();
            $table->string('sbm_path');
            $table->string('sbi_path');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sbmsbis');
    }
};
