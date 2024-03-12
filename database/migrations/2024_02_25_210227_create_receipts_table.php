<?php

use App\Models\BudgetImplementationDetail;
use App\Models\PPK;
use App\Models\Treasurer;
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
        Schema::create('receipts', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['direct', 'treasurer'])->default('direct');
            $table->enum('status', ['draft', 'wait-verificator', 'wait-ppk', 'reject-verificator', 'reject-ppk', 'accept'])->default('draft');
            $table->text('description')->nullable();
            $table->decimal('amount', 15, 2)->default(0);
            $table->date('activity_date')->nullable();
            $table->string('berkas')->nullable();
            $table->string('reference_number')->nullable();
            $table->string('activity_implementer')->nullable();
            $table->foreignId('ppk_id')
                ->constrained('ppks')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignIdFor(Treasurer::class)
                ->nullable()
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('provider');
            $table->string('provider_organization')->nullable();
            $table->foreignIdFor(BudgetImplementationDetail::class)
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('user_entry')
                ->nullable()
                ->constrained('users')
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
        Schema::dropIfExists('receipts');
    }
};
