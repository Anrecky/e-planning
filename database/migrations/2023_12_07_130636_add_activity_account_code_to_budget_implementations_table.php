<?php

use App\Models\AccountCode;
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
        Schema::table('budget_implementations', function (Blueprint $table) {
            $table->foreignIdFor(Activity::class)
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreignIdFor(AccountCode::class)
                ->nullable()
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');

            // Add a unique constraint on activity, account_code, and revision
            $table->unique(['activity_id', 'account_code_id', 'revision'], 'unique_activity_account_revision');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('budget_implementations', function (Blueprint $table) {
            //
        });
    }
};
