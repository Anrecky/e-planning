<?php

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
        Schema::create('ppks', function (Blueprint $table) {
            $table->id();
            $table->string('position');
            $table->string('name');
            $table->string('nik');
            $table->unsignedBigInteger('user_account')->nullable();
            $table->foreign('user_account')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->unsignedBigInteger('staff_account')->nullable();
            $table->foreign('staff_account')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ppks');
    }
};
