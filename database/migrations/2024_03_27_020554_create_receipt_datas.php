<?php

use App\Models\Receipt;
use App\Models\User;
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
        Schema::create('receipt_data', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Receipt::class)
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignIdFor(User::class)
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->json('datas')->nullable();
            $table->decimal('amount', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receipt_followings');
    }
};
