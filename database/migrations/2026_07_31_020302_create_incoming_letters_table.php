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
        Schema::create('incoming_letters', function (Blueprint $table) {

            $table->id();

            $table->uuid('uuid')->unique();

            $table->string('agenda_number')->nullable();

            $table->string('letter_number')->index();

            $table->date('letter_date');

            $table->date('received_date');

            $table->string('sender')->index();

            $table->string('regarding')->index();

            $table->enum('priority', [
                'Biasa',
                'Penting',
                'Segera',
                'Rahasia'
            ])->default('Biasa');

            $table->string('attachment')->nullable();

            $table->string('file')->nullable();

            $table->text('description')->nullable();

            $table->enum('status', [
                'Baru',
                'Didisposisi',
                'Selesai'
            ])->default('Baru')->index();

            $table->foreignId('created_by')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incoming_letters');
    }
};
