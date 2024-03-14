<?php

use App\Enums\Month;
use App\Models\Activity;
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
        Schema::create('withdrawal_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Activity::class)
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');

            // Month column using PHP 8 enum
            $table->tinyInteger('month')->unsigned()->default(Month::Januari->value);

            // Year column
            $table->year('year');

            // Amount withdrawn
            $table->decimal('amount_withdrawn', 15, 2);

            // Notes - Optional
            $table->text('notes')->nullable();

            // Unique index for year and month combination
            $table->unique(['year', 'month']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdrawal_plans');
    }
};
