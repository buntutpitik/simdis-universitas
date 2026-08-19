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
        Schema::create('users', function (Blueprint $table) {

            $table->id();

            $table->uuid('uuid')->unique();

            $table->foreignId('position_id')
                ->constrained('positions')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->string('full_name',150);

            $table->string('email',150)->unique();

            $table->string('phone',20)->nullable();

            $table->string('avatar')->nullable();

            $table->timestamp('email_verified_at')->nullable();

            $table->string('password');

            $table->boolean('is_active')->default(true);

            $table->rememberToken();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};