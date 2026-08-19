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
        Schema::create('disposition_recipients', function (Blueprint $table) {

            $table->id();

            $table->foreignId('disposition_id')
                ->constrained('dispositions')
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->constrained('users')
                ->restrictOnDelete();

            $table->enum('status', [
                'Baru',
                'Diproses',
                'Selesai',
            ])->default('Baru')->index();

            $table->timestamp('processed_at')
                ->nullable();

            $table->timestamp('completed_at')
                ->nullable();

            $table->text('note')
                ->nullable();

            $table->timestamps();

            $table->unique([
                'disposition_id',
                'user_id',
            ]);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disposition_recipients');
    }
};