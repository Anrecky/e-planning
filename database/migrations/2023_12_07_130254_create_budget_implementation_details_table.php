<?php

use App\Models\BudgetImplementation;
use App\Models\ExpenditureUnit;

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
        Schema::create('budget_implementation_details', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('volume')->default(0);
            $table->decimal('price', 15, 2)->default(0);
            $table->decimal('total', 15, 2)->default(0);
            $table->foreignIdFor(ExpenditureUnit::class)
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->foreignIdFor(BudgetImplementation::class)
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budget_implementation_details');
    }
};
