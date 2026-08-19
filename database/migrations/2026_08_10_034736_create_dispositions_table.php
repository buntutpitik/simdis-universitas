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
        Schema::create('dispositions', function (Blueprint $table) {

            $table->id();

            $table->uuid('uuid')->unique();

            $table->foreignId('incoming_letter_id')
                ->constrained('incoming_letters')
                ->cascadeOnDelete();

            $table->foreignId('to_user_id')
                ->constrained('users')
                ->restrictOnDelete();

            $table->text('instruction')->nullable();

            $table->text('note')->nullable();

            $table->enum('priority', [
                'Biasa',
                'Penting',
                'Segera',
                'Rahasia'
            ])->default('Biasa');

            $table->date('deadline')->nullable();

            $table->enum('status', [
                'Baru',
                'Diproses',
                'Selesai'
            ])->default('Baru')->index();

            $table->foreignId('created_by')
                ->constrained('users')
                ->restrictOnDelete();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dispositions');
    }
};