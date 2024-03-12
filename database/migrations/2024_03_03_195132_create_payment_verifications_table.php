<?php

use App\Models\Verificator;
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
        Schema::create('payment_verifications', function (Blueprint $table) {
            $table->id();
            $table->text('description');
            // $table->date('activity_date')->nullable();
            // $table->decimal('amount', 15, 2)->default(0);
            // $table->string('provider');
            // $table->string('implementer_name');
            // $table->string('implementer_nip');
            // $table->string('auditor_name');
            // $table->string('auditor_nip');
            // $table->foreignId('ppk_id')
            //     ->constrained('ppks')
            //     ->onUpdate('cascade')
            //     ->onDelete('cascade');
            // $table->foreignIdFor(Verificator::class)
            //     ->constrained()
            //     ->onUpdate('cascade')
            //     ->onDelete('cascade');
            $table->string('result');
            $table->date('date');
            $table->string('file');

            $table->foreignId('verification_user')
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreignId('receipt_id')
                ->constrained('receipts')
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
        Schema::dropIfExists('payment_verifications');
    }
};
