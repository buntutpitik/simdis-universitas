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
        Schema::create('outgoing_letters', function (Blueprint $table) {

            $table->id();

            $table->uuid('uuid')->unique();

            $table->string('agenda_number')->unique();

            $table->string('letter_number')->index();

            $table->date('letter_date');

            $table->string('recipient')->index();

            $table->string('regarding')->index();

            $table->enum('priority', [
                'Biasa',
                'Penting',
                'Segera',
                'Rahasia',
            ])->default('Biasa');

            $table->string('attachment')->nullable();

            $table->text('description')->nullable();

            $table->string('file')->nullable();

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
        Schema::dropIfExists('outgoing_letters');
    }
};