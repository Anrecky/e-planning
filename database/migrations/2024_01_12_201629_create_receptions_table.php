<?php

use App\Models\AccountCodeReception;
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
        Schema::create('receptions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(AccountCodeReception::class)
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->text('description')->nullable();
            $table->json('type');
            $table->decimal('revenue_target', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receptions');
    }
};
