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
            $table->id();
            $table->string('position');
            $table->string('letter_reference')->nullable();
            $table->foreignIdFor(WorkUnit::class)->onDelete('restrict');
            $table->foreignIdFor(User::class)->onDelete('cascade');
            $table->enum('identity_type', ['nip', 'nik', 'nidn'])->default('nik');
            $table->unsignedBigInteger('head_id')->nullable();
            $table->foreign('head_id')
                ->references('id')
                ->on('employees')
                ->onDelete('set null');
            $table->timestamps();
            $table->unique('user_id');
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
