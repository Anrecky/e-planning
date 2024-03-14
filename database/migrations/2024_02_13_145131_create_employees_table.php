<?php

use App\Models\User;
use App\Models\WorkUnit;
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
        Schema::create('employees', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            $table->string('position');
            $table->foreignIdFor(WorkUnit::class)->onDelete('restrict');
            $table->foreignIdFor(User::class)->onDelete('cascade');
            $table->timestamps();
            $table->unique('user_id');
            $table->unique(['user_id', 'id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
